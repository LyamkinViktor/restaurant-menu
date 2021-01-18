<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface $router
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * Checks if a request was made from the app_login route using the POST method.
     *
     * @param Request $request Request instance.
     *
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * Returns the entered data during login.
     *
     * @param Request $request Request instance.
     *
     * @return array
     */
    public function getCredentials(Request $request): array
    {
        $credentials =  [
            'email'      => $request->request->get('email'),
            'password'   => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        //Write the entered email into the session for re-output if redirected to login
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * Get user.
     *
     * @param mixed $credentials Credentials.
     * @param UserProviderInterface $userProvider User provider interface.
     *
     * @return User|null
     * @throws InvalidCsrfTokenException InvalidCsrfTokenException.
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }

    /**
     * Check user credentials.
     *
     * @param mixed         $credentials Credentials.
     * @param UserInterface $user        Current user.
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * If authentication success.
     *
     * @param Request        $request     Request instance.
     * @param TokenInterface $token       Token interface.
     * @param string         $providerKey Provider key.
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $providerKey
    ): RedirectResponse {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('admin-panel'));
    }

    /**
     * Get login url.
     *
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return $this->router->generate('app_login');
    }
}
