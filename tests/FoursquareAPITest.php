<?php

DEFINE('CLIENT_ID', getenv('FOURSQUARE_CLIENT_ID'));
DEFINE('CLIENT_SECRET', getenv('FOURSQUARE_CLIENT_SECRET'));
DEFINE('TOKEN', getenv('FOURSQUARE_TOKEN'));

class FoursquareAPITest extends PHPUnit_Framework_TestCase {

    public function testPublicEnvironment(){
        $this->assertFalse(CLIENT_ID == false, "Must set the FOURSQUARE_CLIENT_ID environment variable to run public tests");
        $this->assertFalse(CLIENT_SECRET == false, "Must set the FOURSQUARE_CLIENT_SECRET environment variable to run public tests");
    }

    public function testPrivateEnvironment(){
        $this->assertFalse(TOKEN == false, "Must set the FOURSQUARE_TOKEN environment variable to run private tests");
    }

    public function testPublicEndpoint(){   
        $foursquare = new FoursquareAPI(CLIENT_ID, CLIENT_SECRET);
        $venues = json_decode($foursquare->GetPublic('venues/search', array('near'=>'Montreal, QC')));

        // Ensure we get a success response
        $this->assertLessThan(400, $venues->meta->code, $venues->meta->errorDetail);
    }

    public function testPrivateEndpoint(){

        // Load the API and set the token
        $foursquare = new FoursquareAPI(CLIENT_ID, CLIENT_SECRET);
        $foursquare->SetAccessToken(TOKEN);

        // Load response & convert to Stdclass object
        $venues = json_decode($foursquare->GetPrivate('users/self'));

        // Ensure we get a success response
        $this->assertLessThan(400, $venues->meta->code, $venues->meta->errorDetail);
    }
}
