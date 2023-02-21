<?php


class ApiCrudsReservation
{


    function recupererCreneau()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:GET');


        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));

        $requets->jour = $data->jour;

        // recuperer les creneau disponibles

        $result = $requets->checkCreneau();

        // recuperer le nombres des lignes dans la tables creneau

        $creneauDisponibles = array();
        // stoker les id creneau disponible dans idCreneau

        $i = 0;
        while ($row = $result->fetch()) {

            $creneauDisponibles[$i]['time_on'] = $row['time_on'];
            $creneauDisponibles[$i]['time_out'] = $row['time_out'];
            $i++;
        }
        // recupere les creneau disponibles
        echo json_encode($creneauDisponibles);
    }


    function afficherReservation()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:POST');

        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));

        $requets->reference = $data->reference;


        $allReservations = $requets->getReservations();

        $reservations = array();
        $i = 0;
        while ($data = $allReservations->fetch()) {
            $reservations[$i]['time_on'] = $data['time_on'];
            $reservations[$i]['time_out'] = $data['time_out'];
            $reservations[$i]['jour'] = $data['jour'];
            $reservations[$i]['id_reservation'] = $data['id_reservation'];
            //$reservations[$i]['note'] = $data['note'];
            $i++;
        }

        echo  json_encode($reservations);
    }

    function modifierReservations()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:PUT');

        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));

        $requets->time_on = $data->time_on;
        $requets->time_out = $data->time_out;
        $requets->id_reservation = $data->id_reservation;
        $requets->jour = $data->jour;



        $id_cre = $requets->recupererIdCreneau();

        $requets->id_cr = $id_cre['id_cr'];


        if ($requets->modifierReservation()) {
            echo json_encode(
                array(
                    'message' => 'modification est effectuer'
                )
            );
        } else {
            echo json_encode(
                array(
                    'message' => 'modification no effectuer'
                )
            );
        }
    }

    function updateReservation()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:POST');

        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));

        echo var_dump($data);

        $requets->time_on = $data->time_on;
        $requets->time_out = $data->time_out;

        $requets->jour = $data->jour;
        //$requets->note = $data->note;
        $requets->id_reservation = $data->id_reservation;

        $result = $requets->recupererIdCreneau();
        $requets->id_cr = $result['id_cr'];

        if ($requets->updateReservation()) {
            echo json_encode(
                array(
                    'message' => 'true'
                )
            );
        } else {
            echo json_encode(
                array(
                    'message' => 'false'
                )
            );
        }
    }

    function suppReservation()
    {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:PUT');


        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));
        $requets->id_reservation = $data->id_reservation;

        if ($requets->suppReservation()) {
            echo json_encode(
                array(
                    'message' => 'suppression est effectuer'
                )
            );
        } else {
            echo json_encode(
                array(
                    'message' => 'suppression no effectuer'
                )
            );
        }
    }
}