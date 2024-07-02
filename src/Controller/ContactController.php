<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactDTO();
        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->to($data->service)
                ->from($data->email)
                ->subject('Contact')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([ 'data' => $data ]);
            $mailer->send($email);
            $this->addFlash('success', 'Your message has been sent');
            return $this->redirectToRoute('contact.index');
        }
        return $this->render('contact/index.html.twig', [ 'form' => $form]);
    }
}
