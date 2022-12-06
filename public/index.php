<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require __DIR__ . '/../vendor/autoload.php';

require_once '../includes/dboperation.php';
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

            // login insert data
            $app->post('/userlogin',function (Request $request,Response $response)
            {
                  $requestData = json_decode($request->getBody());
                    $username=$requestData->username;
                    $password=$requestData->password;
                    $role=$requestData->role;
                    $c_id=$requestData->c_id;
                    $db = new DbOperation();
                    $responseData = array();
                    if ($db->userlogin($username, $password, $role)){
                    $responseData['error'] = false;
                     $responseData['user'] = $db->getUserByRole($c_id,$username,$role);
                } else {
                    $responseData['error'] = true;
                    $responseData['message'] = 'Invalid username or password';
                }
                $response->getBody()->write(json_encode($responseData));
            });

        //  all students get
        $app->get('/getStudents/{c_id}' ,function (Request $request, Response $response)
        {   $c_id = $request->getAttribute('c_id');
            $db = new DbOperation();
            $result=$db->getStudents($c_id);
            $response->getBody()->write(json_encode($result));
        });

        $app->get('/getlastStudents' ,function (Request $request, Response $response)
        {
            $db = new DbOperation();
            $result=$db->getLastStudent();
            $response->getBody()->write(json_encode($result));
        });

        //  Students admission 
        $app->post('/insertStudents',function (Request $request,Response $response)
        {
            $requestData = json_decode($request->getBody());
            $c_id=$requestData->c_id;
            $a_id=$requestData->a_id;
            $name=$requestData->name;
            $f_name=$requestData->f_name;
            $st_gender=$requestData->st_gender;
            $contact_no=$requestData->contact_no;
            $address=$requestData->address;
            $reference=$requestData->reference;
            $cnic=$requestData->cnic;
            $course=$requestData->course;
            $c_duration=$requestData->c_duration;
            $a_month=$requestData->a_month;
            $ad_date=$requestData->ad_date;
            $total_fee=$requestData->total_fee;
            $installment_no=$requestData->installment_no;
            $first_installment_no=$requestData->first_installment_no;
            $advance=$requestData->advance;
            $remaning_amount=$requestData->remaning_amount;
                $db = new DbOperation();
                $responseData = array();
                    if($db->insertStudents($c_id,$a_id, $name, $f_name, $st_gender, $contact_no, $address, $reference,$cnic, $course,$c_duration,$a_month,$ad_date, $total_fee,$installment_no,$first_installment_no,$advance,$remaning_amount)){
                        $db = new DbOperation();
                        $id=$db->getLastStudent();
                        $result = $db->insertFirstInstallment($id,$c_id,$a_id, $advance,$remaning_amount, $first_installment_no,$a_month);
                        
        $netbalance = $db->getnetbalanceMainAcct($a_id,$c_id);
        $totalnetbalance =0;
        $totalnetbalance = $netbalance + $advance;
        $amount = 0;
        $type = "Addmission";
        $description = "Student Addmission";
        $test = $db->transactions($a_id, $c_id, $a_id, $a_id, $amount, $advance , $totalnetbalance, $type, $description);
        $result1 = $db->updateMainAcct($a_id,$c_id, $totalnetbalance);
        $responseData=array();
                    $responseData['data'] = $result1;
                    $responseData['message'] = 'data inserted sucessfully';
                    $responseData['netbalance'] = $db->getnetbalanceMainAcct($a_id,$c_id);
                } else {
                    $responseData['error'] = true;
                    $responseData['message'] = 'data is not inserted';
                }
            $response->getBody()->write(json_encode($responseData));
        });



        //     updateStudents method
        $app->post('/updateStudents' ,function (Request $request,Response $response)
        {
            $requestData = json_decode($request->getBody());
                $id=$requestData->id;
                $c_id=$requestData->c_id;
                $name=$requestData->name;
                $f_name=$requestData->f_name;
                $st_gender=$requestData->st_gender;
                $contact_no=$requestData->contact_no;
                $address=$requestData->address;
                $reference=$requestData->reference;
                $cnic=$requestData->cnic;
                $course=$requestData->course;
                $c_duration=$requestData->c_duration;
                $ad_date=$requestData->ad_date;
                $total_fee=$requestData->total_fee;
                $installment_no=$requestData->installment_no;
                $advance=$requestData->advance;
                $remaning_amount=$requestData->remaning_amount;
                $status=$requestData->status;
                $st_status=$requestData->st_status;
                $db = new DbOperation();
                $responseData = array();
                if ($db->updateStudents($id,$c_id,$name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,$c_duration,$ad_date,$total_fee,$installment_no,$advance,$remaning_amount,$status,$st_status)){
                $responseData['error'] = false;
                $responseData['message'] = 'updated sucessfully';
            } else {    
                $responseData['error'] = true;
                $responseData['message'] = 'not updated sucessfully';
            }
            $response->getBody()->write(json_encode($responseData));
        });

        //  delete Students one by one with c_id and student id
        $app->post('/deleteStudents' ,function (Request $request,Response $response)
        {
            $requestData = json_decode($request->getBody());
                $id=$requestData->id;
                $c_id=$requestData->c_id;
                $db = new DbOperation();
                $responseData = array();
                if ($db->deleteStudents($id,$c_id)){
                $responseData['error'] = false;
                $responseData['message'] = 'deleted sucessfully';
            } else {
                $responseData['error'] = true;
                $responseData['message'] = 'not deleted sucessfully';
            }
            $response->getBody()->write(json_encode($responseData));
        });

        //  GET STUDENT BY status active and deactive
        $app->get('/get_Student/{c_id}' ,function (Request $request, Response $response)
        {
            $c_id = $request->getAttribute('c_id');
            $db = new DbOperation();
            $result=$db->get_Student($c_id);
            $response->getBody()->write(json_encode($result));
        });

                                                    // Intsallment page api

        //    // get all installments  with (c_id)
        $app->get('/getInstallments/{c_id}' ,function (Request $request, Response $response)
        {
            $c_id = $request->getAttribute('c_id');
            $db = new DbOperation();
            $result=$db->getInstallments($c_id);
            $response->getBody()->write(json_encode($result));
        });

        // insertInstallments method done
        $app->post('/insertInstallments',function (Request $request,Response $response)
        {
            $requestData = json_decode($request->getBody());
            $id=$requestData->id;
            $a_id=$requestData->a_id;
            $c_id=$requestData->c_id;
            $i_amount=$requestData->i_amount;
            $remaning_payment=$requestData->remaning_payment;
            $date=$requestData->date;
            $installmentNo=$requestData->installmentNo;
            $month=$requestData->month;
            //   $status=$requestData->status;
                $db = new DbOperation();
                $responseData = array();
                if ($db->insertInstallments($id,$a_id,$c_id, $i_amount,$remaning_payment,$date,$installmentNo,$month)){
        $netbalance = $db->getnetbalanceMainAcct($a_id,$c_id);
        $totalnetbalance =0;
        $totalnetbalance = $netbalance + $i_amount;
        $amount = 0;
        $type = "Installment";
        $description = "Student Installment";
        $test = $db->transactions($a_id, $c_id, $a_id, $a_id, $amount, $i_amount , $totalnetbalance, $type, $description);
        $result1 = $db->updateMainAcct($a_id,$c_id, $totalnetbalance);
                $responseData['error'] = false;
                $responseData['message'] = 'data inserted sucessfully';
            } else {
                $responseData['error'] = true;
                $responseData['message'] = 'data is not inserted';
            }
            $response->getBody()->write(json_encode($responseData));
        });


        //  deleteInstallments method done
        $app->post('/deleteInstallments' ,function (Request $request,Response $response)
        {
                $requestData = json_decode($request->getBody());
                $i_id=$requestData->i_id;
                $c_id=$requestData->c_id;
                $db = new DbOperation();
                $responseData = array();
                if ($db->deleteInstallments($i_id,$c_id)){
                $responseData['error'] = false;
                $responseData['message'] = 'deleted sucessfully';
            } else {
                $responseData['error'] = true;
                $responseData['message'] = 'not deleted sucessfully';
            }
            $response->getBody()->write(json_encode($responseData));
        });

                //     updateStudents method done
        // $app->post('/updateInstallments' ,function (Request $request,Response $response)
        // {
        //     $requestData = json_decode($request->getBody());
        //         $i_id=$requestData->i_id;
        //         $c_id=$requestData->c_id;
        //         $i_amount=$requestData->i_amount;
        //         $remaning_payment=$requestData->remaning_payment;
        //         $date=$requestData->date;
        //         $installmentNo=$requestData->installmentNo;
        //         $month=$requestData->month;
        //         $db = new DbOperation();
        //         $responseData = array();
        //         if ($db->updateInstallments($i_id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$month)){
        //         $responseData['error'] = false;
        //         $responseData['message'] = 'updated sucessfully';
        //     } else {
        //         $responseData['error'] = true;
        //         $responseData['message'] = 'not updated sucessfully';
        //     }
        //     $response->getBody()->write(json_encode($responseData));
        // });


            // get_Installmentsbyid
            // $app->get('/get_Installments/{i_id}' ,function (Request $request, Response $response)
            // {
            // $i_id = $request->getAttribute('i_id');
            //     $db = new DbOperation();
            //     if($db->get_Installments($i_id)) {
            //         $responseData['data'] = $db->get_Installments($i_id);
            //         $responseData['message'] = 'not updated sucessfully';
            //     }
            //     else {
            //         $responseData['error'] = true;
            //         $responseData['message'] = 'not updated sucessfully';
            //     }
            //     $response->getBody()->write(json_encode($responseData));
            // });

            // get installment by student one by one
            // $app->get('/get_Installments/{i_id}' ,function (Request $request, Response $response)
            // {
            // $i_id = $request->getAttribute('i_id');
            // // $c_id = $request->getAttribute('c_id');
            //     $db = new DbOperation();
            //     $result=$db->get_Installments($i_id);
            //     $response->getBody()->write(json_encode($result));
            // });

              // get installment by student one by one done
            $app->post('/get_Installments',function (Request $request,Response $response)
            {
                $requestData = json_decode($request->getBody());
                $id=$requestData->id;
                $c_id=$requestData->c_id;  
                    $db = new DbOperation();
                    $result = $db->get_Installments($id,$c_id);
                $response->getBody()->write(json_encode($result));
            });


              
        //     $app->post('/get_Installments',function (Request $request,Response $response)
        // {
        //     $requestData = json_decode($request->getBody());
        //     $i_id=$requestData->i_id;
        //     $c_id=$requestData->c_id;
        //         $db = new DbOperation();
        //         $responseData = array();
        //         if ($db->get_Installments($i_id,$c_id)){
        //         $responseData['data'] = $db->get_Installments($i_id, $c_id) ;
        //         $responseData['message'] = 'data inserted successfull';
        //     } else {
        //         $responseData['error'] = true;
        //         $responseData['message'] = 'data is not inserted';
        //     }
        //     $response->getBody()->write(json_encode($responseData));
        // });


            // get_InstallmentsbyStudentId
            // $app->get('/get_InstallmentsbyStudentId/{id}' ,function (Request $request, Response $response)
            // {
            // $id = $request->getAttribute('id');
            //     $db = new DbOperation();
            //     $result=$db->get_InstallmentsbyStudentId($id);
            //     $response->getBody()->write(json_encode($result));
            // });
                //get_InstallmentsbyStudentId done
            $app->post('/get_InstallmentsbyStudentId',function (Request $request,Response $response)
            {
                $requestData = json_decode($request->getBody());
                $id=$requestData->id;
                $c_id=$requestData->c_id;  
                    $db = new DbOperation();
                    $result = $db->get_InstallmentsbyStudentId($id,$c_id);
                $response->getBody()->write(json_encode($result));
            });

            // get installment by month of students
            // $app->get('/get_Installmentsbymonth/{month}' ,function (Request $request, Response $response)
            // {
            // $month = $request->getAttribute('month');
            //     $db = new DbOperation();
            //     $result=$db->get_Installmentsbymonth($month);
            //     $response->getBody()->write(json_encode($result));
            // });
                // get installment by month of students done
            $app->post('/get_Installmentsbymonth',function (Request $request,Response $response)
            {
                $requestData = json_decode($request->getBody());
                $month=$requestData->month;
                $c_id=$requestData->c_id;  
                    $db = new DbOperation();
                    $result = $db->get_Installmentsbymonth($month,$c_id);
                $response->getBody()->write(json_encode($result));
            });

             // getaccountbytype
            // $app->get('/getaccountsbytype/{type}' ,function (Request $request, Response $response)
            // {
            //     $type=$request->getAttribute('type');
            //      $db = new DbOperation();
            //      $result=$db->getaccountsbytype($type);
            //      $response->getBody()->write(json_encode($result));
            // });


        // get graph by date
            $app->post('/getgraphbydate',function (Request $request,Response $response)
        {
            $requestData = json_decode($request->getBody());
            $to_date=$requestData->to_date;
            $from_date=$requestData->from_date;
            // $date=$requestData->date;
                $db = new DbOperation();
                $responseData = array();
                if ($db->getgraphbydate($to_date,$from_date)){
                $responseData['data'] = $db->getgraphbydate($to_date, $from_date) ;
                $responseData['message'] = 'data inserted successfull';
            } else {
                $responseData['error'] = true;
                $responseData['message'] = 'data is not inserted';
            }
            $response->getBody()->write(json_encode($responseData));
        });


             // getaccountbysource
            // $app->get('/getaccountbysource/{source}' ,function (Request $request, Response $response)
            // {
            //     $source=$request->getAttribute('source');
            //      $db = new DbOperation();
            //      $result=$db->getaccountbysource($source);
            //      $response->getBody()->write(json_encode($result));
            // });

            //  acount data get 
        // $app->get('/getAcount/{c_id}' ,function (Request $request, Response $response)
        // {
        //     $c_id = $request->getAttribute('c_id');
        //     $db = new DbOperation();
        //     $result=$db->getAcount($c_id);
        //     $response->getBody()->write(json_encode($result));
        // });
  
        // account data add
        // $app->post('/Addaccount',function (Request $request,Response $response)
        // {
        //     $requestData = json_decode($request->getBody());
        //     $c_id=$requestData->c_id;
        //     $type=$requestData->type;
        //     $source=$requestData->source;
        //     $amount=$requestData->amount;
        //     // $date=$requestData->date;
        //         $db = new DbOperation();
        //         $responseData = array();
        //         if ($db->Addaccount($c_id,$type,$source, $amount)){
        //         $responseData['error'] = false;
        //         $responseData['message'] = 'data inserted sucessfully';
        //     } else {
        //         $responseData['error'] = true;
        //         $responseData['message'] = 'data is not inserted';
        //     }
        //     $response->getBody()->write(json_encode($responseData));
        // });

            //  updateaccount method
        // $app->post('/updateAccount' ,function (Request $request,Response $response)
        // {
        //     $requestData = json_decode($request->getBody());
        //         $a_id=$requestData->a_id;
        //         $c_id=$requestData->c_id;
        //         $type=$requestData->type;
        //         $source=$requestData->source;
        //         $amount=$requestData->amount;
        //         $a_date=$requestData->a_date;
        //         $db = new DbOperation();
        //         $responseData = array();
        //         if ($db->updateAccount($a_id,$c_id,$type,$source, $amount, $a_date)){
        //         $responseData['error'] = false;
        //         $responseData['message'] = 'updated sucessfully';
        //     } else {
        //         $responseData['error'] = true;
        //         $responseData['message'] = 'not updated sucessfully';
        //     }
        //     $response->getBody()->write(json_encode($responseData));
        // });


                // Addaccount date method
            // $app->post('/getAcountDate',function (Request $request,Response $response)
            // {
            //     $requestData = json_decode($request->getBody());
            //     $to_date=$requestData->to_date;
            //     $from_date=$requestData->from_date;
            //     $c_id=$requestData->c_id;    
            //         $db = new DbOperation();
            //         $result = $db->getAcountDate($to_date,$from_date,$c_id);
            //     $response->getBody()->write(json_encode($result));
            // });

            // get account data by type
            // $app->post('/getaccountsbytype',function (Request $request,Response $response)
            // {
            //     $requestData = json_decode($request->getBody());
            //     $type=$requestData->type;
            //     $source=$requestData->source;
            //     $c_id=$requestData->c_id;
            //         $db = new DbOperation();
            //         $responseData = array();
            //         if ($db->getaccountsbytype($type,$source,$c_id)){
            //         $responseData['data'] = $db->getaccountsbytype($type, $source,$c_id) ;
            //         $responseData['message'] = 'data inserted successfull';
            //     } else {
            //         $responseData['error'] = true;
            //         $responseData['message'] = 'data is not inserted';
            //     }
            //     $response->getBody()->write(json_encode($responseData));
            // });

                // graph  all data
                $app->get('/get_alldata_graph/{c_id}' ,function (Request $request, Response $response)
                {
                    $c_id = $request->getAttribute('c_id');
                     $db = new DbOperation();
                     $result=$db->get_alldata_graph($c_id);
                     $response->getBody()->write(json_encode($result));
                });      

                        // get graph data by ide
             $app->post('/post_graphdetailsbyid',function (Request $request, Response $response)
             {
                 $requestData = json_decode($request->getBody());
                 $ide=$requestData->ide;
                 $c_id=$requestData->c_id;
                 $db = new DbOperation();
                 $result=$db->post_graphdetailsbyid($ide,$c_id);
                 $response->getBody()->write(json_encode($result));
             });

   
                // $app->get('/getstudentbycourse/{course}' ,function (Request $request, Response $response)
                // {
                // $course = $request->getAttribute('course');
                //     $db = new DbOperation();
                //     $result=$db->getstudentbycourse($course);
                //     $response->getBody()->write(json_encode($result));
                // });
                    // get student by course
                $app->post('/getstudentbycourse',function (Request $request,Response $response)
                {
                    $requestData = json_decode($request->getBody());
                    $course=$requestData->course;
                    $c_id=$requestData->c_id;  
                        $db = new DbOperation();
                        $result = $db->getstudentbycourse($course,$c_id);
                    $response->getBody()->write(json_encode($result));
                });

                // get student by status active/deactive
                // $app->get('/getstudentbystatus/{st_status}' ,function (Request $request, Response $response)
                // {
                // $st_status = $request->getAttribute('st_status');
                //     $db = new DbOperation();
                //     $result=$db->getstudentbystatus($st_status);
                //     $response->getBody()->write(json_encode($result));
                // });


                    // Account Page Api start

                $app->post('/getmainacct',function (Request $request, Response $response)
                {
                    $requestData = json_decode($request->getBody());
                    $a_id=$requestData->a_id;
                    $c_id=$requestData->c_id;
                    $db = new DbOperation();
                    $result=$db->getnetbalanceMainAcct($a_id,$c_id);
                    $response->getBody()->write(json_encode($result));
                });
                $app->post('/getmainaccounts',function (Request $request, Response $response)
                {
                    $requestData = json_decode($request->getBody());
                    $c_id=$requestData->c_id;
                    $db = new DbOperation();
                    $result=$db->getMainAcct($c_id);
                    $response->getBody()->write(json_encode($result));
                });

                $app->post('/insertTransactions',function (Request $request, Response $response)
                {
                $requestData = json_decode($request->getBody());
                $a_id=$requestData->a_id;
                $c_id=$requestData->c_id;
                $from=$requestData->from;
                $to=$requestData->to;
                $debit=$requestData->debit;
                $credit=$requestData->credit;
                $type=$requestData->type;
                $description=$requestData->description;
                $db = new DbOperation();
                $from_netbalance=$db->getnetbalanceMainAcct($from, $c_id);
                // $c_id=$db->getnetbalanceMainAcct($c_id);
                $netbalance1 = $from_netbalance;
                $netbalance1 = $netbalance1 - $debit; 
                $to_netbalance=$db->getnetbalanceMainAcct($to, $c_id);
                $netbalance2 = $to_netbalance;
                $netbalance2 = $netbalance2 + $debit;
                if($type == "expense") {
                    $result1=$db->transactions($from,$c_id, $from, $to, $debit, $credit,$netbalance1, $type, $description);
                    $result1 = $db->updateMainAcct($from,$c_id, $netbalance1);
                $response->getBody()->write(json_encode($result1));
                }
                if($type == "transaction"){
                    $result1=$db->transactions($c_id,$from, $from, $to, $debit, $credit , $netbalance1, $type, $description);
                    $result1 = $db->updateMainAcct($from,$c_id, $netbalance1);
                    $result1=$db->transactions($c_id,$to, $to, $from, $credit, $debit , $netbalance2, $type, $description);
                    $result1 = $db->updateMainAcct($to,$c_id, $netbalance2);
                    $response->getBody()->write(json_encode($result1));
                }
            });

            // get transaction by a_id
            //     $app->get('/getTransactions/{a_id}' ,function (Request $request, Response $response)
            // {
            //     $a_id=$request->getAttribute('a_id');
            //     $db = new DbOperation();
            //     $result=$db->getTransactions($a_id);
            //     $response->getBody()->write(json_encode($result));
            // });
                //done
            $app->post('/getTransactions',function (Request $request, Response $response)
            {
                $requestData = json_decode($request->getBody());
                $a_id=$requestData->a_id;
                $c_id=$requestData->c_id;
                $db = new DbOperation();
                $result=$db->getTransactions($a_id,$c_id);
                $response->getBody()->write(json_encode($result));
            });

            // gettransactionsbymainaccount
            // $app->post('/gettransactionsbymainaccount',function (Request $request, Response $response)
            // {
            //     $requestData = json_decode($request->getBody());
            //     $a_id=$requestData->a_id;
            //     $type=$requestData->type;
            //     $db = new DbOperation();
            //     $result=$db->gettransactionsbymainaccount($a_id , $type);
            //     $response->getBody()->write(json_encode($result));
            // });
                //done
            
            $app->post('/gettransactionsbymainaccount',function (Request $request, Response $response)
            {
                $requestData = json_decode($request->getBody());
                $a_id=$requestData->a_id;
                $c_id=$requestData->c_id;
                $type=$requestData->type;
                $db = new DbOperation();
                $result=$db->gettransactionsbymainaccount($a_id,$type,$c_id);
                $response->getBody()->write(json_encode($result));
            });

            // gettransactionsbyexpense
            $app->post('/gettransactionsbyexpense',function (Request $request, Response $response)
            {
                $requestData = json_decode($request->getBody());
                $a_id=$requestData->a_id;
                $type=$requestData->type;
                $description=$requestData->description;
                $c_id=$requestData->c_id;
                $db = new DbOperation();
                $result=$db->gettransactionsbyexpense($a_id, $type,$description,$c_id);
                $response->getBody()->write(json_encode($result));
            });

$app->run();
?>
