<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductImageRepository")
 */
class ProductImage
{
    CONST UPLOAD_FOLDER = 'images/products';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filepath;

    /**
     * @Assert\File(
     *     maxSize = "128K",
     *     mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *          "application/pdf",
     *          "application/x-pdf"
     *      },
     *     mimeTypesMessage = "Please upload a valid jpg, jpeg, png, gif, pdf. x-pdf")
     * )
     */
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): self
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function imageUpload()
    {
        $file = $this->getFile();

        if (!$file || !$file instanceof UploadedFile) {
            return;
        }

        $fileName = uniqid() . '.' . $file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $file->move(realpath(self::UPLOAD_FOLDER), $fileName);

            $this->removeFile();
            $this->setFilepath($fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
    }

    public function removeFile()
    {
        $oldFile = realpath(self::UPLOAD_FOLDER). '/' .$this->getFile();
        if (is_file($oldFile)) {
            unlink($oldFile);
        }
    }

    public function getWebPath()
    {
        dump( "/{$this->getFilepath()}");
        if ($this->getFilepath()) {
            return self::UPLOAD_FOLDER . "/{$this->getFilepath()}";
        }

        return self::UPLOAD_FOLDER . "/notFound.jpg";
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getFilepath() ? self::UPLOAD_FOLDER . '/' . $this->getFilepath() : 'New';
    }
}
