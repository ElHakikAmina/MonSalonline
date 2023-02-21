<?php

class ApiUser
{

    function creatUser()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        header('Access-control-Allow-Methods:POST');

        $obj = new Database;
        $conn = $obj->connect();

        $requets = new Requets($conn);
        // inserte dand la table de client
        $data = json_decode(file_get_contents("php://input"));


        $requets->nom = $data->nom;
        $requets->prenom = $data->prenom;
        $requets->tel = $data->tel;

        $requets->create();



        // inserte refrence du client

        $data_client =  $requets->GenerateReference();



        $requets->id_user = $data_client['id_user'];
        $requets->prenom = $data_client['prenom'];


        $requets->reference = $requets->prenom .  $requets->id_user;


        $requets->InsertReference();

        echo json_encode(
            array(
                "reference" => $requets->reference,
            )
        );
    }

    function inserteReservation()
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
        $res = $requets->getIdUser();
        echo $res['id_user'];

        $requets->time_on = $data->time_on;
        $requets->time_out = $data->time_out;
        $requets->id_user = $res['id_user'];
        $requets->jour = $data->jour;
        // $requets->note = $data->note;

        $result = $requets->recupererIdCreneau();
        $requets->id_cr = $result['id_cr'];

        if ($requets->insertReservation()) {
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

    function checkReference()
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
        $result = $requets->checkReference();
        if ($result['reference_existe'] == true) {
            echo json_encode(
                array(
                    'reference_existe' => 'true',
                )
            );
        } else {
            echo json_encode(
                array(
                    'reference_existe' => 'false',
                )
            );
        }
    }
}