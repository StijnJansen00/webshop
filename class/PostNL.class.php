<?php

class PostNL
{
    public $date;

    public function __construct()
    {
        $this->date = date("d-m-Y H:m:s");
    }

    public function createBarcode()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.postnl.nl/shipment/v1_1/barcode?CustomerCode=PEXL&CustomerNumber=10787599&Type=3S&Serie=000000000-999999999',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: t2esExZjG6XQXShrGcEVvGil1VfDDshy'
            ),
        ));

        $barcode = curl_exec($curl);

        curl_close($curl);
        return $barcode;

    }

    public function createSendLabel($barcode, $city, $name, $number, $surname, $street, $zipcode, $email, $phone)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.postnl.nl/shipment/v2_2/label',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
                "Customer": {
                    "Address": {
                        "AddressType": "02",
                        "City": "Apeldoorn",
                        "CompanyName": "4YouOffice",
                        "Countrycode": "NL",
                        "HouseNr": "115",
                        "Street": "Schumanpark",
                        "Zipcode": "7336AS"
                    },
                    "CollectionLocation": "100548",
                    "ContactPerson": "Klantenservice",
                    "CustomerCode": "PEXL",
                    "CustomerNumber": "10787599",
                    "Email": "contact@4YouOffice.nl",
                    "Name": "Klantenservice"
                },
                "Message": {
                    "MessageID": "6e925a82-bddc-490b-a833-90875a6063bb",
                    "MessageTimeStamp": "' . $this->date . '",
                    "Printertype": "GraphicFile|JPG 600 dpi"
                },
                "Shipments": [
                    {
                        "Addresses": [
                            {
                                "AddressType": "01",
                                "City": "' . $city . '",
                                "Countrycode": "NL",
                                "FirstName": "' . $name . '",
                                "HouseNr": "' . $number . '",
                                "HouseNrExt": "",
                                "Name": "' . $surname . '",
                                "Street": "' . $street . '",
                                "Zipcode": "' . $zipcode . '"
                            }
                        ],
                        "Barcode": "' . $barcode . '",
                        "Contacts": [
                            {
                                "ContactType": "01",
                                "Email": "' . $email . '",
                                "SMSNr": "' . $phone . '"
                            }
                        ],
                        "Dimension": {
                            "Weight": "4300"
                        },
                        "ProductCodeDelivery": "3085"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'apikey: t2esExZjG6XQXShrGcEVvGil1VfDDshy',
                'Content-Type: application/json'
            ),
        ));

        $label = curl_exec($curl);
        curl_close($curl);

        return $label;

    }

}