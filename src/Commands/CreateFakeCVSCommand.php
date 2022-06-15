<?php


namespace App\Commands;


use App\Entity\CV;
use App\Repository\CVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateFakeCVSCommand
 * @package App\Commands
 */
class CreateFakeCVSCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = 'add-fake-cvs';

    private $entityManager;
    private $cvRepository;

    const CV_DATA = [
        ['name' => 'Fedor', 'address' => 'street12', 'education' => 'Higer', 'work' => '', 'experience' => 'PHP RUBY PYTHON'],
        ['name' => 'Vasilii', 'address' => 'street13', 'education' => 'Higer', 'work' => '', 'experience' => 'PHP C++'],
        ['name' => 'Eugenii', 'address' => 'street14', 'education' => 'Higer', 'work' => '', 'experience' => 'GO RUBY'],
        ['name' => 'Ion', 'address' => 'street15', 'education' => 'Higer', 'work' => '', 'experience' => 'JS PASCAL'],
        ['name' => 'Petr', 'address' => 'street16', 'education' => 'Higer', 'work' => '', 'experience' => 'PASCAL'],
        ['name' => 'Gavriil', 'address' => 'street17', 'education' => 'Higer', 'work' => '', 'experience' => 'NIM'],
        ['name' => 'Oleg', 'address' => 'street18', 'education' => 'Higer', 'work' => '', 'experience' => 'SCALA'],
        ['name' => 'Viktor', 'address' => 'street19', 'education' => 'Higer', 'work' => '', 'experience' => 'MATLAB'],
        ['name' => 'Alexander', 'address' => 'street20', 'education' => 'Higer', 'work' => '', 'experience' => 'JAVA NIM'],
        ['name' => 'Vitaliy', 'address' => 'street21', 'education' => 'Higer', 'work' => '', 'experience' => 'PYTHON'],
        ['name' => 'Andrei', 'address' => 'street22', 'education' => 'Higer', 'work' => '', 'experience' => 'PROLOG'],
        ['name' => 'Dmitrii', 'address' => 'street23', 'education' => 'Higer', 'work' => '', 'experience' => 'R']
    ];

    public function __construct(EntityManagerInterface $entityManager, CVRepository $cvRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->cvRepository = $cvRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add examples of cv');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        foreach (self::CV_DATA as $cvExample) {
            $cv = new CV();
            $cv->setName($cvExample['name']);
            $cv->setAddress($cvExample['address']);
            $cv->setEducation($cvExample['education']);
            $cv->setWork($cvExample['work']);
            $cv->setExperience($cvExample['experience']);
            $this->cvRepository->add($cv);
        }

        $this->entityManager->flush();
        $output->writeln('CVs were created successfuly');
        return Command::SUCCESS;
    }
}