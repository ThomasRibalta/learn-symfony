<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em, UserPasswordHasherInterface $pass): Response
    {
        // $user = new User();
        // $user->setUsername('admin')
        // ->setPassword($pass->hashPassword($user, 'admin'))
        // ->setEmail('admin@admin')
        // ->setRoles([]);
        // $em->persist($user);
        // $em->flush();
        return $this->render('home/index.html.twig');
    }
}
