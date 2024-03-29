<?php
class Requets
{
    public $conn;
    public $nom;
    public $prenom;
    public $tel;
    public $reference;
    public $id_user;
    public $jour;
    public $time_on;
    public $time_out;
    public $id_cr;
    public $id_reservation;
    public $note;
    public $DayName;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    // public function oneHourPerDay($id_user,$date)
    // {
    //     $sql = 'SELECT COUNT(*) FROM reservation WHERE jour=:date_reservation and id_user=:user_id ';
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    //     $stmt->bindParam(':date_reservation', $date, PDO::PARAM_STR);
    //     $stmt->execute();
    //     $count = $stmt->fetchColumn();

    //     return $count;
    // }
    // API creat client
    public function create()
    {

        $query = "INSERT INTO client SET nom=:nom,prenom=:prenom,tel=:tel";
        $strm = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->tel = htmlspecialchars(strip_tags($this->tel));

        $strm->bindParam(':nom', $this->nom);
        $strm->bindParam(':prenom', $this->prenom);
        $strm->bindParam(':tel', $this->tel);


        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }

    public function GenerateReference()
    {

        $query = 'SELECT *FROM client ORDER BY client.id_user DESC LIMIT 1 ';
        $req = $this->conn->prepare($query);
        $req->execute();
        return $row = $req->fetch();
    }
    public function getIdUser()
    {
        $reference = $this->reference;
        $query = "SELECT id_user FROM client WHERE reference='$reference'";
        $req = $this->conn->prepare($query);
        $req->execute();
        return $row = $req->fetch();
    }

    function checkReference()
    {
        $reference = $this->reference;
        $query = "SELECT EXISTS( SELECT * FROM client WHERE reference='$reference' ) AS reference_existe";
        $req = $this->conn->prepare($query);
        $req->execute();

        return  $req->fetch();
    }

    public function InsertReference()
    {
        $query = "UPDATE  client SET reference=:reference WHERE id_user=:id_user";
        $strm = $this->conn->prepare($query);
        $this->reference = htmlspecialchars(strip_tags($this->reference));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $strm->bindParam(':reference', $this->reference);
        $strm->bindParam(':id_user', $this->id_user);


        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }

    // api recuperer creneau disponible

    public function checkAvailableCreneau()
    {

        $jour = $this->jour;
        $DayName =$this->DayName;
        if($DayName=="Sunday"){
            $query = " SELECT *FROM créneau WHERE dimanche=1 and id_cr NOT IN(SELECT id_cr FROM reservation WHERE jour='$jour')";

        }
        elseif($DayName=="Friday"){
            $query = " SELECT *FROM créneau WHERE vendredi=1 and id_cr NOT IN(SELECT id_cr FROM reservation WHERE jour='$jour')";

        }
        else{
            $query = " SELECT *FROM créneau WHERE restesemaine=1 and id_cr NOT IN(SELECT id_cr FROM reservation WHERE jour='$jour')";

        }

        $req = $this->conn->prepare($query);
        $req->execute();

        return  $req;
    }

    public function checkCreneau()
    {

        $jour = $this->jour;
        $DayName =$this->DayName;
        if($DayName=="Sunday"){
            $query = " SELECT *FROM créneau WHERE dimanche=1 ";

        }
        elseif($DayName=="Friday"){
            $query = " SELECT *FROM créneau WHERE vendredi=1 ";

        }
        else{
            $query = " SELECT *FROM créneau WHERE restesemaine=1 ";

        }

        $req = $this->conn->prepare($query);
        $req->execute();

        return  $req;
    }
   
    public function getAllRDV()
    {

        $jour = $this->jour;
        $DayName =$this->DayName;
        
            $query = "SELECT time_on, time_out FROM `créneau` JOIN reservation ON reservation.id_cr = `créneau`.id_cr WHERE reservation.jour = '$this->jour';";

        $req = $this->conn->prepare($query);
        $req->execute();

        return  $req->fetchAll();
    }



    public function recupererIdCreneau()
    {
        $time_on = $this->time_on;
        $time_out = $this->time_out;
        $query = "SELECT id_cr FROM créneau WHERE time_on='$time_on'AND time_out='$time_out'";
        $req = $this->conn->prepare($query);
        $req->execute();

        return  $req->fetch();
    }



    // api inserer les reservations

    public function insertReservation()
    {
        // Check if the user has already reserved a slot on the same day
    $query = "SELECT COUNT(*) as count FROM reservation WHERE id_user=:id_user AND jour=:jour";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_user', $this->id_user);
    $stmt->bindParam(':jour', $this->jour);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // User has already reserved a slot on the same day
        return false;
    }
        $query = "INSERT INTO reservation SET  id_user=:id_user,id_cr=:id_cr,jour=:jour";
        $strm = $this->conn->prepare($query);

        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $this->id_cr = htmlspecialchars(strip_tags($this->id_cr));
        $this->jour = htmlspecialchars(strip_tags($this->jour));
        // $this->note = htmlspecialchars(strip_tags($this->note));

        $strm->bindParam(':id_user', $this->id_user);
        $strm->bindParam(':id_cr', $this->id_cr);
        $strm->bindParam(':jour', $this->jour);
        // $strm->bindParam(':note', $this->note);


        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }

    public function updateReservation()
    {


        $query = "UPDATE  reservation SET  id_cr=:id_cr,jour=:jour WHERE id_reservation=:id_reservation";
        $strm = $this->conn->prepare($query);


        $this->id_cr = htmlspecialchars(strip_tags($this->id_cr));
        $this->jour = htmlspecialchars(strip_tags($this->jour));
        $this->id_reservation = htmlspecialchars(strip_tags($this->id_reservation));


        $strm->bindParam(':id_cr', $this->id_cr);
        $strm->bindParam(':jour', $this->jour);
        $strm->bindParam(':id_reservation', $this->id_reservation);


        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }


    // api afficher les reservations

    public function getReservations()
    {
        $reference = $this->reference;
        $query = "SELECT id_user FROM client WHERE reference='$reference'";
        $req = $this->conn->prepare($query);
        $req->execute();
        $x =  $req->fetch();
        $user = $x['id_user'];


        $query2 = "SELECT créneau.time_on,time_out,reservation.id_cr,jour
        ,id_reservation FROM reservation INNER JOIN créneau ON  reservation.id_cr=créneau.id_cr WHERE reservation.id_user='$user'";
        $req2 = $this->conn->prepare($query2);
        $req2->execute();
        return $req2;
    }
   

    // api modifier les reservations 

    public function modifierReservation()
    {


        $query = "UPDATE  reservation SET jour=:jour ,id_cr=:id_cr WHERE id_reservation=:id_reservation";
        $strm = $this->conn->prepare($query);
        $this->jour = htmlspecialchars(strip_tags($this->jour));
        $this->id_cr = htmlspecialchars(strip_tags($this->id_cr));
        $this->id_reservation = htmlspecialchars(strip_tags($this->id_reservation));

        $strm->bindParam(':jour', $this->jour);
        $strm->bindParam(':id_cr', $this->id_cr);
        $strm->bindParam(':id_reservation', $this->id_reservation);



        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }

    // api supprimer reservations
    public function suppReservation()
    {

        $query = "DELETE FROM reservation WHERE  id_reservation=:id_reservation";
        $strm = $this->conn->prepare($query);
        $this->id_reservation = htmlspecialchars(strip_tags($this->id_reservation));
        $strm->bindParam(':id_reservation', $this->id_reservation);
        if ($strm->execute()) {
            return true;
        } else {
            false;
        }
    }
}