<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstName',  TextType::class,      ['label' => 'Prénom*', 'attr' => ['placeholder' => 'Prénom']])
        ->add('lastName',   TextType::class,      ['label' => 'Nom*', 'attr' => ['placeholder' => 'Nom']])
        ->add('address',    TextType::class,      ['label' => 'Adresse*', 'attr' => ['placeholder' => 'Adresse']])
        ->add('zipCode',    TextType::class,      ['label' => 'Code Postal*', 'attr' => ['placeholder' => 'Code Postal']])
        ->add('city',       TextType::class,      ['label' => 'Ville*', 'attr' => ['placeholder' => 'Ville']])
        ->add('phone',      TelType::class,       ['label' => 'Téléphone*', 'attr' => ['placeholder' => 'Téléphone']])
        ->add('email',      EmailType::class,      ['label' => 'Email*', 'attr' => ['placeholder' => 'Email']])
        ->add('message',    TextareaType::class,  ['label' => 'Message*', 'attr' => ['placeholder' => 'Saisissez votre message...', 'rows' => 4]])
        ->add('captcha',    RecaptchaType::class, ['mapped' => false])
        ->add('agreeTerms', CheckboxType::class,  ['label' => 'En cochant cette case, j\'accepte que mes données soient utilisées pour me recontacter', 'mapped' => false])
        ->add('save',       SubmitType::class,    ['label' => 'Envoyer ma demande', 'attr' => ['class' => 'btn-item']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
