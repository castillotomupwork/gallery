<?php

namespace App\Entity;

use App\Repository\TempTrackerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=TempTrackerRepository::class)
 */
class TempTracker
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(message="Must enter a number.")
     */
    private $temperature;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getCreatedAt()
    {
        if (is_null($this->createdAt)) {
            $this->createdAt = '';
        }

        return $this->createdAt;
    }

    public function setCreatedAt($createdAt = null)
    {
        if (empty($createdAt) || is_null($createdAt)) {
            $createdAt = '';
        } else {
            if ($createdAt == 'now') {
                $createdAt = '';
            }
        }

        $setDate = new \DateTime($createdAt);

        $this->createdAt = $setDate;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $valid = true;

        if (!is_numeric($this->getTemperature())) {
            $context->buildViolation('Please enter a valid number.')
                ->atPath('temperature')
                ->addViolation();
            $valid = false;
        }

        if ($valid === true && !preg_match('/^[+\-]?\d+(\.(\d{2}))?$/', $this->getTemperature()))
        {
            $context->buildViolation('Up to 2 decimal points only.')
                ->atPath('temperature')
                ->addViolation();
        }
    }
}
