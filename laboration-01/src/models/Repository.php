<?php

namespace models;

class Repository {
    
    private $filePath = "courses.json";
    
    public function getScrapeResult() {
        $ret = null;

        if (file_exists($this -> filePath)) {
            $savedResult = json_decode(file_get_contents($this -> filePath));

            $courses = array();
            foreach ($savedResult -> courses as $course) {
                $lastestPost = $course ->  latestPost;
                $courses[] = new Course($course -> name, $course -> url, $course -> code, $course -> description, $lastestPost -> title, $lastestPost -> writer, $lastestPost -> timeForPost);
            }
            
            $ret = new ScrapeResult($savedResult -> timeLastScraping, $savedResult -> numberOfCourses, $courses);
        }
        
        return $ret;
    }
    
    public function saveScrapeResult(\models\ScrapeResult $scrapeResult) {
        file_put_contents($this -> filePath, $scrapeResult -> toJSON());
    }
}