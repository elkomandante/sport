<?php


namespace App\Tests\Functional\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Response\TraceableResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthControllerTest extends WebTestCase
{

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    const testUsername = 'test_user';
    const testPassword = 'test_password';

    /**
     * @var HttpClientInterface $client
     */
    private $client;

    protected function setUp()
    {
        self::bootKernel();
        $this->entityManager = self::$container->get('doctrine.orm.default_entity_manager');
        $this->client = self::$container->get('http_client');
        $this->userPasswordEncoder = self::$container->get('security.password_encoder');

    }

    private function createTestUser() : User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => self::testUsername]);
        if($user) return $user;
        $user = new User();
        $user->setUsername(self::testUsername);
        $user->setPassword($this->userPasswordEncoder->encodePassword($user,self::testPassword));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    private function deleteTestUser()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'username' => self::testUsername
        ]);

        if(!$user) return;

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function testRegister()
    {

        $response = $this->client->request('POST','https://localhost:8000/auth/register',[
            'json' => [
                'username' => self::testUsername,
                'password' => self::testPassword
            ]
        ]);

        $response->getContent();

        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy([
                'username' => self::testUsername
            ]
        );

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::testUsername, $userEntity->getUsername());

        $this->deleteTestUser();
    }

    public function testRegisterWithExistingUsername()
    {
        $user = $this->createTestUser();

        try {
            $response = $this->client->request('POST',"https://localhost:8000/auth/register",[
                'json' => [
                    'username' => $user->getUsername(),
                    'password' => self::testPassword
                ]
            ]);
            $statusCode = $response->getStatusCode();
        }catch (TransportExceptionInterface $transportException){
            $this->assertTrue(false);
            return;
        }

        $content = json_decode($response->getContent(false),true);


        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertArrayHasKey('errors',$content);
        if(isset($content['errors'])){
            $this->assertArrayHasKey('username',$content['errors']);
        }

        $this->deleteTestUser();
    }

    public function testLogin()
    {
        $this->createTestUser();

        try {
            $response = $this->client->request('POST','https://localhost:8000/auth/login',[
                'json' => [
                    'username' => self::testUsername,
                    'password' => self::testPassword
                ]
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getContent(false),true);
        }catch (TransportExceptionInterface $exception){
            $this->assertTrue(false);
            return false;
        }

        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('token',$content);
        $this->deleteTestUser();

    }


    public function testBadLogin()
    {
        try {
            $response = $this->client->request('POST','https://localhost:8000/auth/login',[
                'json' => [
                    'username' => uniqid(),
                    'password' => uniqid()
                ]
            ]);
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getContent(false),true);
        }catch (TransportExceptionInterface $exception){
            $this->assertTrue(false);
            return false;
        }

        $this->assertEquals(401,$statusCode);
        $this->assertEquals("Invalid credentials.",$content['message']);
    }


}