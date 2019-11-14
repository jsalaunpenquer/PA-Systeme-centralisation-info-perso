<?php
// src/FormUserType.php
namespace App\Form;

use App\Entity\Client;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\CsrfFormLoginBundle\Form\UserLoginType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenomClient', TextType::class)
            ->add('nomClient', TextType::class)
            ->add('login', TextType::class)
            ->add('adresseMailPerso', EmailType::class)
            ->add('adresseClient', TextType::class)
            ->add('numTel',TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'invalid_message' => 'Le mot de passe doit contenir entre 8 et 12 caractères',
                'constraints' => array(
                    new NotBlank(array('message' => 'Vide' )),
                    new Length(array('min' => 8, 'max'=> 12, 'minMessage' => "Mot de passe de plus de 8 caractères", 'maxMessage' =>"De moins de 12 caractères"))
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Client::class,
        ));
    }
}