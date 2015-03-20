<?php

// Visitee - the one that have been visited
interface Visitee {
  // this part makes the connection and passes 
  public function accept(Visitor $visitor);
}

class ArtDestination implements Visitee{
  private $destinationName;
  private $destinationSpokenLanguage;

  public function __construct($newDestinationName, $newDestinationSpokenLanguage) {
    $this->destinationName = $newDestinationName;
    $this->destinationSpokenLanguage = $newDestinationSpokenLanguage;
  }

  public function getDestinationName() { 
    return 'The ' . $this->destinationName;
  }
  
  public function destinationSpokenLanguage() { 
    return ' strictly ' . $this->destinationSpokenLanguage; 
  }

  public function accept(Visitor $visitor) {
    $visitor->visitArtDestination($this);
  }
}

class ForeignDestination implements Visitee{
  private $destinationName;
  private $destinationSpokenLanguage;

  public function __construct($newDestinationName, $newDestinationSpokenLanguage) {
    $this->destinationName = $newDestinationName;
    $this->destinationSpokenLanguage = $newDestinationSpokenLanguage;
  }

  public function getDestinationName() {
    return $this->destinationName . ' - (the beautiful) ';
  }
  
  public function destinationSpokenLanguage() {
    return $this->destinationSpokenLanguage;
  }

  public function accept(Visitor $visitor) {
    $visitor->visitForeignDestination($this);
  }
}

class PartyDestination implements Visitee{
  private $destinationName;
  private $destinationSpokenLanguage;

  public function __construct($newDestinationName, $newDestinationSpokenLanguage) {
    $this->destinationName = $newDestinationName;
    $this->destinationSpokenLanguage = $newDestinationSpokenLanguage;
  }

  public function getDestinationName() {
    return $this->destinationName . ' -==- Party place ';
  }
  public function destinationSpokenLanguage() {
    return $this->destinationSpokenLanguage . ' :: party ppl :: - ';
  }

  public function accept(Visitor $visitor) {
    $visitor->visitPartyDestination($this);
  }
}

// this instance has to define each possible Visitor options
interface Visitor {
  public function visitArtDestination(Visitee $visitee);
  public function visitForeignDestination(Visitee $visitee);
  public function visitPartyDestination(Visitee $visitee);
}

class YoungIndividualVisitor implements Visitor{

  public function visitArtDestination(Visitee $visitee) {
    print 'I: ' . $visitee->getDestinationName() . ' is a bit boring.' . "\n";
  }

  public function visitForeignDestination(Visitee $visitee) {
    print 'I: At ' . $visitee->getDestinationName() . ' they speak ' . $visitee->destinationSpokenLanguage() . "\n";
  }

  public function visitPartyDestination(Visitee $visitee) {
    print 'I: Let\'s go to ' . $visitee->getDestinationName() . ' where they speak ' . $visitee->destinationSpokenLanguage() . "\n";
  }
}

class CoupleVisitor implements Visitor{

  public function visitArtDestination(Visitee $visitee) {
    print 'C: We enjoyed it at: ' .$visitee->getDestinationName() . ' with its great artworks.' . "\n";
  }

  public function visitForeignDestination(Visitee $visitee) {
    print 'C: At ' . $visitee->getDestinationName() . ' we leared ' . $visitee->destinationSpokenLanguage() . ' language' . "\n";
  }

  public function visitPartyDestination(Visitee $visitee) {
    print 'C: We enjoyed it at '  . $visitee->getDestinationName() . "\n";
  }
}

class VisitorTest extends \PHPunit_Framework_Testcase {

  protected $partyDestination;
  protected $artDestination;
  protected $foreignDestination;

  public function setUP() {
    $this->partyDestination = new PartyDestination('Brasil', 'Portuguese');
    $this->artDestination = new ArtDestination('Paris', 'French');
    $this->foreignDestination = new ForeignDestination('India', 'Hindi');
  }

  public function testCoupleArtProgram() {
    $coupleVisitors = new CoupleVisitor();
    $this->artDestination->accept($coupleVisitors);
  }

  public function testIndividualPartyProgram() {
    $individualVisitor = new YoungIndividualVisitor();
    $this->partyDestination->accept($individualVisitor);
  }

  public function testCoupleForeignProgram() {
    $coupleVisitors = new CoupleVisitor();
    $this->foreignDestination->accept($coupleVisitors);
  }

}


