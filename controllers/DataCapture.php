<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datacapture extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary helpers and libraries
        $this->load->helper('file');  // To manage file operations
    }

    public function index() {
        // URLs to scrape
        $urls = [
            'https://www.eventbrite.ca/d/canada--toronto/technology--events/',
            'https://www.meetup.com/cities/ca/on/toronto/tech/',
            'https://www.lumaevents.com/technology-events-in-toronto'
        ];
        //echo $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";exit;
        // Initialize CSV file path
        //echo realpath("cache/events.csv");
//print_r($fullPath);

       echo  $csvFile = 'http://localhost/events.csv';
        //exit;

        $handle = fopen($csvFile, 'w');

        // Write the CSV header
        fputcsv($handle, ['Date', 'Day', 'Link', 'Image', 'Time', 'Title', 'Organizer', 'Location', 'Price']);

        // Loop through URLs and scrape data
        foreach ($urls as $url) {
            // Fetch HTML content from the URL using cURL
            $html = $this->get_html($url);

            if ($html) {
                // Extract event data from HTML content
                $events = $this->extract_event_data($html);
                
                // Write event data to CSV file
                foreach ($events as $event) {
                    fputcsv($handle, $event);
                }
            }
        }

        // Close CSV file
        fclose($handle);
        
        echo "CSV file has been created successfully.";
    }

    // Function to fetch HTML content using cURL
    private function get_html($url) {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36");

        // Disable SSL verification (not recommended for production)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $html = curl_exec($ch);

        // Handle cURL errors
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            return null;
        }

        curl_close($ch);
        return $html;
    }

    // Function to extract event data using regular expressions
    private function extract_event_data($html) {
        $events = [];

        // Example regex pattern to extract event data (you will need to adjust these to match the HTML structure of the pages)
        preg_match_all('/<div class="event-class">.*?<\/div>/is', $html, $eventMatches);

        foreach ($eventMatches[0] as $eventHtml) {
            // Extract date (example selector: <span class="date">date</span>)
            preg_match('/<span class="date">(.*?)<\/span>/is', $eventHtml, $dateMatches);
            $date = $dateMatches[1] ?? 'N/A';

            // Extract title (example selector: <h2 class="title">Title</h2>)
            preg_match('/<h2 class="title">(.*?)<\/h2>/is', $eventHtml, $titleMatches);
            $title = $titleMatches[1] ?? 'N/A';

            // Extract time (example selector: <span class="time">time</span>)
            preg_match('/<span class="time">(.*?)<\/span>/is', $eventHtml, $timeMatches);
            $time = $timeMatches[1] ?? 'N/A';

            // Extract organizer (example selector: <span class="organizer">Organizer</span>)
            preg_match('/<span class="organizer">(.*?)<\/span>/is', $eventHtml, $organizerMatches);
            $organizer = $organizerMatches[1] ?? 'N/A';

            // Extract location (example selector: <span class="location">Location</span>)
            preg_match('/<span class="location">(.*?)<\/span>/is', $eventHtml, $locationMatches);
            $location = $locationMatches[1] ?? 'N/A';

            // Extract price (example selector: <span class="price">Price</span>)
            preg_match('/<span class="price">(.*?)<\/span>/is', $eventHtml, $priceMatches);
            $price = $priceMatches[1] ?? 'Free';

            // Extract event link (example selector: <a href="url">Event</a>)
            preg_match('/<a href="(.*?)"/is', $eventHtml, $linkMatches);
            $link = $linkMatches[1] ?? 'N/A';

            // Extract image (example selector: <img src="image.jpg">)
            preg_match('/<img src="(.*?)"/is', $eventHtml, $imageMatches);
            $image = $imageMatches[1] ?? 'N/A';

            // Get the day of the week from the date
            $day = date('l', strtotime($date));

            // Store event data in an array
            $events[] = [
                'Date' => $date,
                'Day' => $day,
                'Link' => $link,
                'Image' => $image,
                'Time' => $time,
                'Title' => $title,
                'Organizer' => $organizer,
                'Location' => $location,
                'Price' => $price
            ];
        }

        return $events;
    }
}