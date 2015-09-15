<?php

namespace A2C\Bundle\UserBundle\Command;

use A2C\Bundle\UserBundle\Entity\User;
use A2C\Bundle\UserBundle\Model\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UserRegistrationCommand
 * @package A2C\Bundle\UserBundle\Command
 *
 * @author Adan Felipe Medeiros<adan.grg@gmail.com>
 * @version 0.1
 */
class UserRegistrationCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('a2c:user:registration')
            ->setDescription('Este comando é responsavel por criar um novo usuario no banco de dados')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $output->writeln("<comment>Insira os dados a seguir para cadastrar um usuario!</comment>");

        $username = $dialog->ask($output,'Username: ');
        $password = $dialog->ask($output,'Password: ');
        $email    = $dialog->ask($output,'Email: ');
        $roles    = $dialog->ask($output,'Roles: ');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setActive(true);

        $manager = new UserManager();

        $manager->setContainer($this->getContainer());
        $manager->setEntity($user);
        if ($manager->saveUser())
            $output->writeln("<info>Usuario Cadastrado com sucesso!</info>");
        else
            $output->writeln("<error>Problemas ao inserir o usuario!</error>");
    }
}
