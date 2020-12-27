<?php

namespace App\Command;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface ;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserAddrolesCommand extends Command
{
    protected static $defaultName = 'app:user:addroles';
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em ;
        parent:: __construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Modifier un utilisateur en lui ajoutant de nouveaux roles')
            ->addArgument('email', InputArgument::REQUIRED, 'EMAIL ADDRESS OF THE USER YOU WANT TO EDIT.')
            ->addArgument('roles',  InputArgument::REQUIRED, 'the roles you want to add to the user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $roles = $input->getArgument('roles');
        $userRepository =$this->em->getRepository(User :: class);
        $user = $userRepository->findOneByEmail($email);
        if ($user) {
            $user->addRoles($roles);
            $this->em->flush();

            $io->success('the roles has been succcessfully added to the user.');

        }

        else {
            $io->error('there is no user with that email address.');

        }

       

        return 0;
    }
}
