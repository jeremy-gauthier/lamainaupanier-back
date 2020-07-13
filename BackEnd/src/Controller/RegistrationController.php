<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Producer;
use App\Entity\Customer;
use App\Repository\ProducerRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;



/**
 * @Route("/api")
 */
class RegistrationController extends AbstractController
{
    private $passwordEncoder;

public function __construct(UserPasswordEncoderInterface $passwordEncoder)
{
    $this->passwordEncoder = $passwordEncoder;        
}
    
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('PlainPassword')->getData()
                )
            );

            $user->setConfirmationToken(random_bytes(24));
            $user->setLastLoginAt(new \DateTime());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register_producer", name="producer_add", methods={"POST"})
     */
    
    public function newProducer(Request $request, UserPasswordEncoderInterface $passwordEncoder,SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ClassMetadataFactoryInterface $classMetadataFactory, ObjectNormalizer $normalizer)
    {
        $jsonRecieved = $request->getContent();
        try {
            $producer = $serializer->deserialize($jsonRecieved, Producer::class, 'json');
            $producer->setCreatedAt(new \DateTime());

            
            $encoded = $this->passwordEncoder->encodePassword(
                $producer,
                $producer->getPassword()
            );
            $producer->setPassword($encoded);

            $producer->setConfirmationToken(random_bytes(24));
            $em->persist($producer);
            $em->flush();
            
            

            return $this->json($producer, 201, [], ['groups' => 'producer:infos']);
        }catch(NotEncodableValueException $e)
        {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }




    /**
     * @Route("/register_customer", name="customer_add", methods={"POST"})
     */
    
    public function newCustomer(Request $request, UserPasswordEncoderInterface $passwordEncoder,SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ClassMetadataFactoryInterface $classMetadataFactory, ObjectNormalizer $normalizer)
    {
        $jsonRecieved = $request->getContent();
        try {
            $customer = $serializer->deserialize($jsonRecieved, Customer::class, 'json');
            $customer->setCreatedAt(new \DateTime());

            
            $encoded = $this->passwordEncoder->encodePassword(
                $customer,
                $customer->getPassword()
            );
            $customer->setPassword($encoded);

            $customer->setConfirmationToken(random_bytes(24));
            $em->persist($customer);
            $em->flush();
            
            

            return $this->json($customer, 201, [], ['groups' => 'customer:show']);
        }catch(NotEncodableValueException $e)
        {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    }

