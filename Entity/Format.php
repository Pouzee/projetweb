<?php

namespace AppBundle\Entity;

/**
 * Format
 */
class Format
{

    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $format;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return Format
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
}
