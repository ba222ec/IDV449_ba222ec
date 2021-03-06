<?php

namespace models;

/**
 * Collects the result from scraping
 * 
 * @author Svante Arvedson
 */
class ScrapeResult {
	
    /**
     * @var $timeLastScraping int Timestamp
     */
    private $timeLastScraping;
    
    /**
     * @var $numberOfCourses int Number of course objects in $courses
     */
    private $numberOfCourses;
    
    /**
     * @var $courses array An array with course objects
     */
    private $courses;
    
    /**
     * @param $timeLastScraping int
     * @param $numberOfCourses int
     * @param $courses array
     */
	public function __construct($timeLastScraping, $numberOfCourses, array $courses) {
	    $this -> timeLastScraping = $timeLastScraping;
        $this -> numberOfCourses = $numberOfCourses;
        $this -> courses = $courses;
	}
    
    /**
     * @return int $this->timeLastScraping
     */
    public function getTimeLastScraping() {
        return $this -> timeLastScraping;
    }

    /**
     * @return array An array with all scraped course URLs
     */
    public function getScrapedUrls() {
        $ret = array();
        foreach ($this -> courses as $course) {
            $ret[] = $course -> getUrl();
        }
        
        return $ret;
    }
    
    /**
     * Return an array with all properties and their values
     * 
     * @return array
     */
    public function toArray() {
        $courses = array();
        foreach ($this -> courses as $course) {
            $courses[] = $course -> toArray();
        }
        
        return array (
            "timeLastScraping" => $this -> timeLastScraping,
            "numberOfCourses" => $this -> numberOfCourses,
            "courses" => $courses
        );
    }
}
