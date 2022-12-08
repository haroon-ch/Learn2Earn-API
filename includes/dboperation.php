<?php

use phpDocumentor\Reflection\DocBlock\Description;

class DbOperation
{
    private $con;
    function __construct()
    {
        require_once dirname(__FILE__) . '/dbconnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }
            // user login 
            function userlogin($username, $password, $role)
            {
                 $stmt = $this->con->prepare("SELECT u_id FROM login WHERE username = ? AND password = ? AND role = ?");
                 $stmt->bind_param("sss", $username, $password , $role);
                 $stmt->execute();
                 $stmt->store_result();
                 return $stmt->num_rows > 0;
            }
            function getUserByRole( $c_id, $username, $role)
            {
                $stmt = $this->con->prepare("SELECT u_id,  c_id, username,password,role from login WHERE username = ? AND role = ?");
                $stmt->bind_param("ss", $username, $role);
                $stmt->execute();
                $stmt->bind_result( $u_id , $c_id,$username,$password , $role);
                $stmt->fetch();
                $User = array();
                $User['u_id']=$u_id;
                $User['c_id']=$c_id;
                $User['username'] = $username;
                $User['password'] = $password;
                $User['role']=$role;
                return $User;
            }

            //  all students get
            function getStudents($c_id)
            {
                if($c_id == 3){
                    $stmt = $this->con->prepare ("SELECT `c_id`, `a_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`, `c_duration`, `a_month`, `upcoming_installment`, `ad_date`, `total_fee`, `installment_no`, `per_installment`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status` FROM `a_student`");
                    // $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id, $name,$f_name, $st_gender,$contact_no, $address,$reference, $cnic,$course,$c_duration,$a_month,$upcoming_installment, $ad_date,$total_fee, $installment_no,$per_installment,$first_installment_no,$advance,$remaning_amount,$status,$st_status);
                    // $stmt->fetch();
                    $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                    $test['id'] = $id;
                    $test['c_id'] = $c_id;
                    $test['name'] = $name;
                    $test['f_name'] = $f_name;
                    $test['st_gender'] = $st_gender;
                    $test['contact_no'] = $contact_no;
                    $test['address'] = $address;
                    $test['reference'] = $reference;
                    $test['cnic'] = $cnic;
                    $test['course'] = $course;
                    $test['c_duration'] = $c_duration;
                    $test['a_month'] = $a_month;
                    $test['upcoming_installment'] = $upcoming_installment;
                    $test['ad_date'] = $ad_date;
                    $test['total_fee'] = $total_fee;
                    $test['installment_no'] = $installment_no;
                    $test['per_installment'] = $per_installment;
                    $test['first_installment_no'] = $first_installment_no;
                    $test['advance'] = $advance;
                    $test['remaning_amount'] = $remaning_amount;
                    $test['status'] = $status;
                    $test['st_status'] = $st_status;
                    array_push($cat, $test);
                    }
                    return $cat;
                }
                else{
                    $stmt = $this->con->prepare ("SELECT `c_id`, `a_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`, `c_duration`, `a_month`, `upcoming_installment`, `ad_date`, `total_fee`, `installment_no`, `per_installment`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status` FROM a_student WHERE c_id=?");
                    $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id, $name,$f_name, $st_gender,$contact_no, $address,$reference, $cnic,$course,$c_duration,$a_month,$upcoming_installment, $ad_date,$total_fee, $installment_no,$per_installment,$first_installment_no,$advance,$remaning_amount,$status,$st_status);
                    // $stmt->fetch();
                    $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                    $test['id'] = $id;
                    $test['c_id'] = $c_id;
                    $test['name'] = $name;
                    $test['f_name'] = $f_name;
                    $test['st_gender'] = $st_gender;
                    $test['contact_no'] = $contact_no;
                    $test['address'] = $address;
                    $test['reference'] = $reference;
                    $test['cnic'] = $cnic;
                    $test['course'] = $course;
                    $test['c_duration'] = $c_duration;
                    $test['a_month'] = $a_month;
                    $test['upcoming_installment'] = $upcoming_installment;
                    $test['ad_date'] = $ad_date;
                    $test['total_fee'] = $total_fee;
                    $test['installment_no'] = $installment_no;
                    $test['per_installment'] = $per_installment;
                    $test['first_installment_no'] = $first_installment_no;
                    $test['advance'] = $advance;
                    $test['remaning_amount'] = $remaning_amount;
                    $test['status'] = $status;
                    $test['st_status'] = $st_status;
                    array_push($cat, $test);
                    }
                    return $cat;
                }
            }
            // get last student
            function getLastStudent()
            {
            $stmt = $this->con->prepare ("SELECT `id` FROM `a_student` where `id` = (select MAX(`id`) from `a_student`)");
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();
            $test = array();
            $test['id'] = $id;
            
            return $id;
            }

            // student first insertInstallments addmission time 
            function insertFirstInstallment($id,$c_id,$a_id,$i_amount,$remaning_payment,$installmentNo,$month,$upcoming_installment)
            {       
            date_default_timezone_set("Asia/Karachi");
            $date = date("ymd");
            $stmt=$this->con->prepare("INSERT INTO `installments` (`id`,`c_id`,`a_id`, `i_amount`,`remaning_payment`, `date`, `installmentNo`,`month`,`upcoming_installment`) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiisiss", $id,$c_id,$a_id,$i_amount,$remaning_payment, $date,$installmentNo,$month,$upcoming_installment);
            if ($stmt->execute())
                {
                    return PROFILE_CREATED;
                }
                    return PROFILE_NOT_CREATED;
            } 

                //  Students admission 
            function insertStudents($c_id,$a_id,$name,$f_name, $st_gender, $contact_no,$address, $reference,$cnic, $course,$c_duration,$a_month,$upcoming_installment,$ad_date, $total_fee,$installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount)
            {       
                // date_default_timezone_set("Asia/Karachi");
                // $ad_date = date("ymd");
                $status="pending";
                $st_status="active";
                $amount=0;
                $stmt=$this->con->prepare("INSERT INTO `a_student`(`c_id`, `a_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`, `c_duration`, `a_month`,`upcoming_installment`, `ad_date`, `total_fee`, `installment_no`,`per_installment`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iissssssssssssiiiiiiss",$c_id,$a_id, $name,$f_name, $st_gender, $contact_no,$address, $reference,$cnic, $course,$c_duration,$a_month,$upcoming_installment,$ad_date,$total_fee,$installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount,$status,$st_status);
                if ($stmt->execute())
                {
                    $stmt = $this->con->prepare("SELECT netbalance FROM main_account where a_id = (select MAX(a_id) from main_account)");
                    $stmt->execute();
                    $stmt->bind_result($netbalance);
                    $stmt->fetch();
                    return PROFILE_CREATED;
                }
                else{
                    return PROFILE_NOT_CREATED;
                }
                
            }  

            //       update Students 
                 function updateStudents($id,$c_id,$name,$f_name, $st_gender, $contact_no,$address, $reference,$cnic, $course,$c_duration,$a_month,$upcoming_installment,$ad_date, $total_fee,$installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount,$status,$st_status)
            {
                $stmt=$this->con->prepare("UPDATE `a_student` SET `name`=?,`f_name`=?,`st_gender`=?,`contact_no`=?,`address`=?,`reference`=?,`cnic`=?,`course`=?,`c_duration`=?,`a_month`=?,`upcoming_installment`=?,`ad_date`=?,`total_fee`=?,`installment_no`=?,`per_installment`=?,`first_installment_no`=?,`advance`=?,`remaning_amount`=?,`status`=?,`st_status`=? WHERE id = ? AND c_id=?");
                $stmt->bind_param("ssssssssssssiiiiiissii",$name,$f_name, $st_gender, $contact_no,$address, $reference,$cnic, $course,$c_duration,$a_month,$upcoming_installment,$ad_date, $total_fee,$installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount,$status,$st_status,$id,$c_id);
                if($stmt->execute())
                {
                    return PROFILE_CREATED;
                }
                return PROFILE_NOT_CREATED;
            }
            // function updateStudents($id,$c_id,$a_id,$name,$f_name,$st_gender, $contact_no,$address, $reference,	$cnic, $course,$c_duration,$a_month,$upcoming_installment,$ad_date, $total_fee,$installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount, $status,$st_status)
            // {
            //     $stmt=$this->con->prepare("UPDATE `a_student` SET `id`=?,`c_id`=?,`a_id`=?,`name`=?,`f_name`=?,`st_gender`=?,`contact_no`=?,`address`=?,`reference`=?,`cnic`=?,`course`=?,`c_duration`=?,`a_month`=?,`upcoming_installment`=?,`ad_date`=?,`total_fee`=?,`installment_no`=?,`per_installment`=?,`first_installment_no`=?,`advance`=?,`remaning_amount`=?,`status`=?,`st_status`=? WHERE id = ? AND c_id=?");
            //     $stmt->bind_param("ssssssssssssiiiiiissiii",$name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,$c_duration,$a_month,$upcoming_installment,$ad_date,$total_fee, $installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount,$status,$st_status,$id,$c_id,$a_id);
            //     if($stmt->execute())
            //     {
            //         return PROFILE_CREATED;
            //     }
            //     return PROFILE_NOT_CREATED;
            // }

            // delete Students one by one with c_id and student id
            function deleteStudents($id,$c_id)
            {
                $stmt=$this->con->prepare("DELETE FROM `a_student`  WHERE id = (?) AND c_id=(?)");
                $stmt->bind_param("ii",$id,$c_id);
                if($stmt->execute())
                {
                    return PROFILE_CREATED;
                }
                return PROFILE_NOT_CREATED;
            }


            //  GET STUDENT BY status active and deactive
            function get_Student($c_id)
            {
                if($c_id == 3){
                    $stmt = $this->con->prepare ("SELECT  `id`,`c_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`,`c_duration`, `ad_date`, `total_fee`, `installment_no`,`first_installment_no`,`advance`,`remaning_amount`, `status`, `st_status` FROM `a_student` WHERE `st_status`='active'");
                    // $stmt->bind_param("i",$c_id);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id,$name,$f_name, $st_gender,$contact_no, $address,$reference, $cnic,$course,$c_duration, $ad_date,$total_fee,$installment_no,$first_installment_no,$advance,$remaning_amount, $status,$st_status);
                    // $stmt->fetch();
                      $cat = array();
                             while ($stmt->fetch()) {
                                 $test = array();
                    $test['id'] = $id;
                    $test['c_id'] = $c_id;
                    $test['name'] = $name;
                    $test['f_name'] = $f_name;
                    $test['st_gender'] = $st_gender;
                    $test['contact_no'] = $contact_no;
                    $test['address'] = $address;
                    $test['reference'] = $reference;
                    $test['cnic'] = $cnic;
                    $test['course'] = $course;
                    $test['c_duration'] = $c_duration;
                    $test['ad_date'] = $ad_date;
                    $test['total_fee'] = $total_fee;
                    $test['installment_no'] = $installment_no;
                    $test['first_installment_no'] = $first_installment_no;
                    $test['advance'] = $advance;
                    $test['remaning_amount'] = $remaning_amount;
                    $test['status'] = $status;
                    $test['st_status'] = $st_status;
                     array_push($cat, $test);
                    }
                    return $cat;
                }else{
                    $stmt = $this->con->prepare ("SELECT  `id`,`c_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`,`c_duration`, `ad_date`, `total_fee`, `installment_no`,`first_installment_no`,`advance`,`remaning_amount`, `status`, `st_status` FROM `a_student` WHERE `st_status`='active' AND c_id=(?)");
                    $stmt->bind_param("i",$c_id);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id,$name,$f_name, $st_gender,$contact_no, $address,$reference, $cnic,$course,$c_duration, $ad_date,$total_fee,$installment_no,$first_installment_no,$advance,$remaning_amount, $status,$st_status);
                    // $stmt->fetch();
                      $cat = array();
                             while ($stmt->fetch()) {
                                 $test = array();
                    $test['id'] = $id;
                    $test['c_id'] = $c_id;
                    $test['name'] = $name;
                    $test['f_name'] = $f_name;
                    $test['st_gender'] = $st_gender;
                    $test['contact_no'] = $contact_no;
                    $test['address'] = $address;
                    $test['reference'] = $reference;
                    $test['cnic'] = $cnic;
                    $test['course'] = $course;
                    $test['c_duration'] = $c_duration;
                    $test['ad_date'] = $ad_date;
                    $test['total_fee'] = $total_fee;
                    $test['installment_no'] = $installment_no;
                    $test['first_installment_no'] = $first_installment_no;
                    $test['advance'] = $advance;
                    $test['remaning_amount'] = $remaning_amount;
                    $test['status'] = $status;
                    $test['st_status'] = $st_status;
                     array_push($cat, $test);
                    }
                    return $cat;
                }
            }
                                     // Intsallment page api

              // get all installments with (c_id) 
            function getInstallments($c_id)
            {
            if($c_id == 3){
                $stmt = $this->con->prepare ("SELECT a_student.id,a_student.c_id,a_student.name,a_student.f_name,a_student.st_gender,a_student.contact_no,a_student.address,
                a_student.reference,a_student.cnic,a_student.course,a_student.c_duration, a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.first_installment_no,a_student.advance,
                a_student.status,a_student.st_status,installments.i_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM a_student JOIN installments ON a_student.id = installments.id");
                // $stmt->bind_param("i",$c_id);
                $stmt->execute();
                $stmt->bind_result($id,$c_id, $name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,
                $c_duration, $ad_date,$total_fee,$installment_no,$first_installment_no, $advance, $status,$st_status, $i_id,$i_amount,$remaning_payment, $date,$installmentNo);
                // $stmt->fetch();
                $cat = array();
                        while ($stmt->fetch()) {
                            $test = array();
                $test['id'] = $id;
                $test['c_id'] = $c_id;
                $test['name'] = $name;
                $test['f_name'] = $f_name;
                $test['st_gender'] = $st_gender;
                $test['contact_no'] = $contact_no;
                $test['address'] = $address;
                $test['reference'] = $reference;
                $test['cnic'] = $cnic;
                $test['course'] = $course;
                $test['c_duration'] = $c_duration;
                $test['ad_date'] = $ad_date;
                $test['total_fee'] = $total_fee;
                $test['installment_no'] = $installment_no;
                $test['first_installment_no'] = $first_installment_no;
                $test['advance'] = $advance;
                $test['status'] = $status;
                $test['st_status'] = $st_status;
                $test['i_id'] = $i_id;
                $test['i_amount'] = $i_amount;
                $test['remaning_payment'] = $remaning_payment;
                $test['date'] = $date;
                $test['installmentNo'] = $installmentNo;
                array_push($cat, $test);
                }
                return $cat;
            }
            else{
                $stmt = $this->con->prepare ("SELECT a_student.id,a_student.c_id,a_student.name,a_student.f_name,a_student.st_gender,a_student.contact_no,a_student.address,
                a_student.reference,a_student.cnic,a_student.course,a_student.c_duration, a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.first_installment_no,a_student.advance,
                a_student.status,a_student.st_status,installments.i_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM a_student JOIN installments ON a_student.id = installments.id WHERE installments.c_id =(?)");
                $stmt->bind_param("i",$c_id);
                $stmt->execute();
                $stmt->bind_result($id,$c_id, $name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,
                $c_duration, $ad_date,$total_fee,$installment_no,$first_installment_no, $advance, $status,$st_status, $i_id,$i_amount,$remaning_payment, $date,$installmentNo);
                // $stmt->fetch();
                $cat = array();
                        while ($stmt->fetch()) {
                            $test = array();
                $test['id'] = $id;
                $test['c_id'] = $c_id;
                $test['name'] = $name;
                $test['f_name'] = $f_name;
                $test['st_gender'] = $st_gender;
                $test['contact_no'] = $contact_no;
                $test['address'] = $address;
                $test['reference'] = $reference;
                $test['cnic'] = $cnic;
                $test['course'] = $course;
                $test['c_duration'] = $c_duration;
                $test['ad_date'] = $ad_date;
                $test['total_fee'] = $total_fee;
                $test['installment_no'] = $installment_no;
                $test['first_installment_no'] = $first_installment_no;
                $test['advance'] = $advance;
                $test['status'] = $status;
                $test['st_status'] = $st_status;
                $test['i_id'] = $i_id;
                $test['i_amount'] = $i_amount;
                $test['remaning_payment'] = $remaning_payment;
                $test['date'] = $date;
                $test['installmentNo'] = $installmentNo;
                array_push($cat, $test);
                }
                return $cat;
            }
            }

               //   insertInstallments method
            function insertInstallments($id,$a_id,$c_id,$i_amount,$remaning_payment,$date,$installmentNo,$month,$upcoming_installment)
            {       
            $stmt=$this->con->prepare("INSERT INTO `installments` (`id`,`a_id`,`c_id`, `i_amount`,`remaning_payment`, `date`, `installmentNo`,`month`,`upcoming_installment`) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiisiss", $id,$a_id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$month,$upcoming_installment);
            if ($stmt->execute())
                {
                    // return PROFILE_CREATED;
                }
                    return PROFILE_NOT_CREATED;
            }  


             //  delete Installments 
            function deleteInstallments($i_id,$c_id)
            {
                $stmt=$this->con->prepare("DELETE FROM `installments`  WHERE i_id = (?) AND c_id=(?)");
                $stmt->bind_param("ii",$i_id,$c_id);
                if($stmt->execute())
                {
                    return PROFILE_CREATED;
                }
                return PROFILE_NOT_CREATED;
            }

    
            //       update Installments done
            // function updateInstallments($i_id,$c_id,$i_amount,$remaning_payment,$date,$installmentNo,$month)
            // {
            //     $stmt=$this->con->prepare("UPDATE `installments` SET `i_amount`=(?),`remaning_payment`=(?),`date`=(?),`installmentNo`=(?),`month`=(?) WHERE i_id = (?) AND c_id = (?)");
            //     $stmt->bind_param("iisisii",$i_amount,$remaning_payment,$date,$installmentNo,$month,$i_id,$c_id);
            //     if($stmt->execute())
            //     {
            //         return PROFILE_CREATED;
            //     }
            //     return PROFILE_NOT_CREATED;
            // }

    
            // get last installment by student one by one
            function get_Installments($id,$c_id)
            {
                if($c_id == 3){
            $stmt = $this->con->prepare ("SELECT installments.i_id,installments.id,installments.c_id,installments.i_amount,installments.remaning_payment, installments.date,installments.installmentNo, a_student.name,a_student.f_name,a_student.st_gender,a_student.contact_no,a_student.address,a_student.reference, a_student.cnic,a_student.course,a_student.c_duration,
            a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.first_installment_no,a_student.advance,a_student.status, a_student.st_status FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.i_id = (SELECT MAX(i_id) FROM installments WHERE installments.id =?)");
             $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->bind_result( $i_id,$id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$name,$f_name,$st_gender,$contact_no,
                                $address,$reference,$cnic,$course,$c_duration, 
                                $ad_date,$total_fee,$installment_no,$first_installment_no, $advance, $status,$st_status);
            // $stmt->fetch();
              $cat = array();
                     while ($stmt->fetch()) {
                         $test = array();
            $test['i_id'] = $i_id;
            $test['id'] = $id;
            $test['c_id'] = $c_id;
            $test['i_amount'] = $i_amount;
            $test['remaning_payment'] = $remaning_payment;
            $test['date'] = $date;
            $test['installmentNo'] = $installmentNo;
            $test['name'] = $name;
            $test['f_name'] = $f_name;
            $test['st_gender'] = $st_gender;
            $test['contact_no'] = $contact_no;
            $test['address'] = $address;
            $test['reference'] = $reference;
            $test['cnic'] = $cnic;
            $test['course'] = $course;
            $test['c_duration'] = $c_duration;
            $test['ad_date'] = $ad_date;
            $test['total_fee'] = $total_fee;
            $test['installment_no'] = $installment_no;
            $test['first_installment_no'] = $first_installment_no;
            $test['advance'] = $advance;
            $test['status'] = $status;
            $test['st_status'] = $st_status;
             array_push($cat, $test);
            }
            return $cat;
                }
                else{
               $stmt = $this->con->prepare ("SELECT installments.i_id,installments.id,installments.c_id,installments.i_amount,installments.remaning_payment, installments.date,installments.installmentNo, a_student.name,a_student.f_name,a_student.st_gender,
               a_student.contact_no,a_student.address,a_student.reference, a_student.cnic,a_student.course,a_student.c_duration,a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.first_installment_no,a_student.advance,a_student.status, a_student.st_status FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.i_id = (SELECT MAX(i_id) FROM installments WHERE installments.id =?) AND installments.c_id=?");
             $stmt->bind_param("ii",$id,$c_id);
            $stmt->execute();
            $stmt->bind_result( $i_id,$id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$name,$f_name,$st_gender,$contact_no,
                                $address,$reference,$cnic,$course,$c_duration, 
                                $ad_date,$total_fee,$installment_no,$first_installment_no, $advance, $status,$st_status);
            // $stmt->fetch();
              $cat = array();
                     while ($stmt->fetch()) {
                         $test = array();
            $test['i_id'] = $i_id;
            $test['id'] = $id;
            $test['c_id'] = $c_id;
            $test['i_amount'] = $i_amount;
            $test['remaning_payment'] = $remaning_payment;
            $test['date'] = $date;
            $test['installmentNo'] = $installmentNo;
            $test['name'] = $name;
            $test['f_name'] = $f_name;
            $test['st_gender'] = $st_gender;
            $test['contact_no'] = $contact_no;
            $test['address'] = $address;
            $test['reference'] = $reference;
            $test['cnic'] = $cnic;
            $test['course'] = $course;
            $test['c_duration'] = $c_duration;
            $test['ad_date'] = $ad_date;
            $test['total_fee'] = $total_fee;
            $test['installment_no'] = $installment_no;
            $test['first_installment_no'] = $first_installment_no;
            $test['advance'] = $advance;
            $test['status'] = $status;
            $test['st_status'] = $st_status;
             array_push($cat, $test);
            }
            return $cat;
                }
            }

            // get all installments by student one by one done
            function get_InstallmentsbyStudentId($id,$c_id)
            {
                if($c_id == 3){
                    $stmt = $this->con->prepare ("SELECT installments.i_id,installments.id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo,installments.month,a_student.name,a_student.f_name,a_student.st_gender,a_student.contact_no,a_student.address,a_student.reference,a_student.cnic,a_student.course,a_student.c_duration,a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.advance,a_student.status,a_student.st_status FROM installments JOIN a_student ON installments.id = a_student.id WHERE a_student.id = ?");
                    $stmt->bind_param("i",$id);
                   $stmt->execute();
                   $stmt->bind_result( $i_id,$id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$month,$name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,$c_duration, $ad_date,$total_fee,$installment_no, $advance, $status,$st_status);
                   // $stmt->fetch();
                     $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                   $test['i_id'] = $i_id;
                   $test['id'] = $id;
                   $test['c_id'] = $c_id;
                   $test['i_amount'] = $i_amount;
                   $test['remaning_payment'] = $remaning_payment;
                   $test['date'] = $date;
                   $test['installmentNo'] = $installmentNo;
                   $test['month'] = $month;
                   $test['name'] = $name;
                   $test['f_name'] = $f_name;
                   $test['st_gender'] = $st_gender;
                   $test['contact_no'] = $address;
                   $test['reference'] = $reference;
                   $test['cnic'] = $cnic;
                   $test['course'] = $course;
                   $test['c_duration'] = $c_duration;
                   $test['ad_date'] = $ad_date;
                   $test['total_fee'] = $total_fee;
                   $test['installment_no'] = $installment_no;
                   $test['advance'] = $advance;
                   $test['status'] = $status;
                   $test['st_status'] = $st_status;
                    array_push($cat, $test);
                   }
                   return $cat;
                }
                else{
                    $stmt = $this->con->prepare ("SELECT installments.i_id,installments.id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo,installments.month,a_student.name,a_student.f_name,a_student.st_gender,a_student.contact_no,a_student.address,a_student.reference,a_student.cnic,a_student.course,a_student.c_duration,a_student.ad_date,a_student.total_fee,a_student.installment_no,a_student.advance,a_student.status,a_student.st_status FROM installments JOIN a_student ON installments.id = a_student.id WHERE a_student.id = ? AND installments.c_id=?");
                    $stmt->bind_param("ii",$id,$c_id);
                   $stmt->execute();
                   $stmt->bind_result( $i_id,$id,$c_id,$i_amount,$remaning_payment, $date,$installmentNo,$month,$name,$f_name,$st_gender,$contact_no,$address,$reference,$cnic,$course,$c_duration, $ad_date,$total_fee,$installment_no, $advance, $status,$st_status);
                   // $stmt->fetch();
                     $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                   $test['i_id'] = $i_id;
                   $test['id'] = $id;
                   $test['c_id'] = $c_id;
                   $test['i_amount'] = $i_amount;
                   $test['remaning_payment'] = $remaning_payment;
                   $test['date'] = $date;
                   $test['installmentNo'] = $installmentNo;
                   $test['month'] = $month;
                   $test['name'] = $name;
                   $test['f_name'] = $f_name;
                   $test['st_gender'] = $st_gender;
                   $test['contact_no'] = $address;
                   $test['reference'] = $reference;
                   $test['cnic'] = $cnic;
                   $test['course'] = $course;
                   $test['c_duration'] = $c_duration;
                   $test['ad_date'] = $ad_date;
                   $test['total_fee'] = $total_fee;
                   $test['installment_no'] = $installment_no;
                   $test['advance'] = $advance;
                   $test['status'] = $status;
                   $test['st_status'] = $st_status;
                    array_push($cat, $test);
                   }
                   return $cat;
                }
            }

            // student get by month his installments done
            // SELECT `id` , `name` FROM a_student WHERE id IN ( SELECT DISTINCT(id) FROM installments WHERE month != ?)
            function get_Installmentsbymonth($month,$c_id)
            {
                if($c_id == 3){
                    $stmt = $this->con->prepare ("SELECT a_student.`id`,a_student.`c_id`,a_student.`name`,a_student.`f_name`,a_student.`st_gender`,
                    a_student.`contact_no`,a_student.`address`,a_student.`reference`,a_student.`cnic`,a_student.`course`,
                    a_student.`c_duration`,a_student.`ad_date`,a_student.`total_fee`,a_student.`installment_no`,a_student.per_installment,a_student.`advance`,
                    a_student.`status`,a_student.`st_status`,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo,
                    installments.month,installments.upcoming_installment FROM a_student JOIN installments ON a_student.id = installments.id
                     WHERE a_student.id IN (SELECT installments.id FROM installments WHERE month != ? )");
                    $stmt->bind_param("s",$month);
                   $stmt->execute();    
                   $stmt->bind_result( $id,$c_id,$name,$f_name,$st_gender,$contact_no,$address,$reference,
                                       $cnic,$course,$c_duration,$ad_date, $total_fee,$installment_no,$per_installment,$advance,$status,$st_status,
                                       $i_amount,$remaning_payment
                                    ,$date,$installmentNo,$month,$upcoming_installment);
                   // $stmt->fetch();
                     $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                   $test['id'] = $id;
                   $test['c_id'] = $c_id;
                   $test['name'] = $name;
                   $test['f_name'] = $f_name;
                   $test['st_gender'] = $st_gender;
                   $test['contact_no'] = $contact_no;
                   $test['address'] = $address;
                   $test['reference'] = $reference;
                   $test['cnic'] = $cnic;
                   $test['course'] = $course;
                   $test['c_duration'] = $c_duration;
                   $test['ad_date'] = $ad_date;
                   $test['total_fee'] = $total_fee;
                   $test['installment_no'] = $installment_no;
                   $test['per_installment'] = $per_installment;
                   $test['advance'] = $advance;
                   $test['status'] = $status;
                   $test['i_amount'] = $i_amount;
                   $test['remaning_payment'] = $remaning_payment;
                   $test['date'] = $date;
                   $test['installmentNo'] = $installmentNo;
                   $test['month'] = $month;
                   $test['upcoming_installment'] = $upcoming_installment;
                  
                    array_push($cat, $test);
                   }
                   return $cat;
                }

                else
                
                {

                    $stmt = $this->con->prepare ("SELECT a_student.`id`,a_student.`c_id`,a_student.`name`,a_student.`f_name`,a_student.`st_gender`,
                    a_student.`contact_no`,a_student.`address`,a_student.`reference`,a_student.`cnic`,a_student.`course`,
                    a_student.`c_duration`,a_student.`ad_date`,a_student.`total_fee`,a_student.`installment_no`,a_student.per_installment,a_student.`advance`,
                    a_student.`status`,a_student.`st_status`,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo,
                    installments.month,installments.upcoming_installment FROM a_student JOIN installments ON a_student.id = installments.id WHERE a_student.id IN (SELECT installments.id FROM installments WHERE month != ? ) AND installments.c_id=?");
                    $stmt->bind_param("si",$month,$c_id);
                   $stmt->execute();
                   $stmt->bind_result( $id,$c_id,$name,$f_name,$st_gender,$contact_no,$address,$reference,
                                       $cnic,$course,$c_duration,$ad_date, $total_fee,$installment_no,$per_installment,$advance,$status,$st_status,
                                       $i_amount,$remaning_payment
                                       ,$date,$installmentNo,$month,$upcoming_installment);
                   // $stmt->fetch();
                     $cat = array();
                            while ($stmt->fetch()) {
                                $test = array();
                   $test['id'] = $id;
                   $test['c_id'] = $c_id;
                   $test['name'] = $name;
                   $test['f_name'] = $f_name;
                   $test['st_gender'] = $st_gender;
                   $test['contact_no'] = $contact_no;
                   $test['address'] = $address;
                   $test['reference'] = $reference;
                   $test['cnic'] = $cnic;
                   $test['course'] = $course;
                   $test['c_duration'] = $c_duration;
                   $test['ad_date'] = $ad_date;
                   $test['total_fee'] = $total_fee;
                   $test['installment_no'] = $installment_no;
                   $test['per_installment'] = $per_installment;
                   $test['advance'] = $advance;
                   $test['status'] = $status;
                   $test['st_status'] = $st_status;
                   $test['i_amount'] = $i_amount;
                   $test['remaning_payment'] = $remaning_payment;
                   $test['date'] = $date;
                   $test['installmentNo'] = $installmentNo;
                   $test['month'] = $month;
                   $test['upcoming_installment'] = $upcoming_installment;
                    array_push($cat, $test);
                   }
                   return $cat;
                }
            }                                    // account page api

            // get graph data by date 
        
            function get_alldata_graph($c_id)
            {
                if($c_id == 3){
                    $cat3 = array();                //   Total expense by last 7 days
                    $stmt = $this->con->prepare("select DAYNAME(t_date) as day,transactions.c_id, SUM(netbalance) as total_netbalance from transactions WHERE t_date >= NOW() + INTERVAL -7 DAY AND t_date <  NOW() + INTERVAL  0 DAY group by day(t_date) order by day(t_date)");
                    // $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($day,$c_id, $total_netbalance);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['day'] = $day;
                $data['c_id'] = $c_id;
                $data['total_netbalance'] = $total_netbalance;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                        //   Total expense by last 7 Month
                $stmt = $this->con->prepare("select date_format(t_date,'%M') as month ,transactions.c_id,date_format(t_date,'%Y') as year ,SUM(netbalance) as total_netbalance from transactions WHERE t_date >= now()-interval 7 month group by year(t_date),month(t_date) order by year(t_date)");
                // $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month,$c_id, $year, $total_netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['month'] = $month;
                $data['c_id'] = $c_id;
                $data['year'] = $year;
                $data['total_netbalance'] = $total_netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);        //   Total Installments  by last 7 days
                $stmt = $this->con->prepare("SELECT DAYNAME(date) as day,installments.c_id, SUM(i_amount) as total_installments FROM installments WHERE date >= NOW() + INTERVAL -7 DAY AND date < NOW() + INTERVAL 0 DAY GROUP BY day(date) ORDER BY day(date)");
                // $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($day,$c_id, $total_installments);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['day'] = $day;
                $data['c_id'] = $c_id;
                $data['total_installments'] = $total_installments;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);   //   Total Installments by last 7 Month
                $stmt = $this->con->prepare("SELECT date_format(date ,'%M') as month,installments.c_id,date_format(date ,'%Y') as year, SUM(i_amount) as total_installments FROM installments WHERE date >= NOW()-INTERVAL 7 month GROUP BY year(date), month(date) ORDER BY year(date),month(date)");
                // $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month,$c_id, $year , $total_installments);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['month'] = $month;
                $data['c_id'] = $c_id;
                $data['year'] = $year;
                $data['total_installments'] = $total_installments;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
                else{
                    $cat3 = array();                //   Total expense by last 7 days
                    $stmt = $this->con->prepare("select DAYNAME(t_date) as day,transactions.c_id, SUM(netbalance) as total_netbalance from transactions WHERE c_id=? AND t_date >= NOW() + INTERVAL -7 DAY AND t_date <  NOW() + INTERVAL  0 DAY group by day(t_date) order by day(t_date)");
                    $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($day,$c_id, $total_netbalance);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['day'] = $day;
                $data['c_id'] = $c_id;
                $data['total_netbalance'] = $total_netbalance;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                        //   Total expense by last 7 Month
                $stmt = $this->con->prepare("select date_format(t_date,'%M') as month ,transactions.c_id,date_format(t_date,'%Y') as year ,SUM(netbalance) as total_netbalance from transactions WHERE c_id=? AND t_date >= now()-interval 7 month group by year(t_date),month(t_date) order by year(t_date)");
                $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month,$c_id, $year, $total_netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['month'] = $month;
                $data['c_id'] = $c_id;
                $data['year'] = $year;
                $data['total_netbalance'] = $total_netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);        //   Total Installments  by last 7 days
                $stmt = $this->con->prepare("SELECT DAYNAME(date) as day,installments.c_id, SUM(i_amount) as total_installments FROM installments WHERE c_id=? AND date >= NOW() + INTERVAL -7 DAY AND date < NOW() + INTERVAL 0 DAY GROUP BY day(date) ORDER BY day(date)");
                $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($day,$c_id, $total_installments);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['day'] = $day;
                $data['c_id'] = $c_id;
                $data['total_installments'] = $total_installments;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);   //   Total Installments by last 7 Month
                $stmt = $this->con->prepare("SELECT date_format(date ,'%M') as month,installments.c_id,date_format(date ,'%Y') as year, SUM(i_amount) as total_installments FROM installments WHERE c_id=? AND date >= NOW()-INTERVAL 7 month GROUP BY year(date), month(date) ORDER BY year(date),month(date)");
                $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month,$c_id, $year , $total_installments);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['month'] = $month;
                $data['c_id'] = $c_id;
                $data['year'] = $year;
                $data['total_installments'] = $total_installments;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
            }


            // graph by id details
            function post_graphdetailsbyid($ide,$c_id)
            {             
                                        //   Total account  details by last 7 days
                if($c_id == 3){
                    if($ide == 1)
                    {     
                          $stmt = $this->con->prepare ("SELECT DAYNAME(transactions.t_date) as day, transactions.t_id,transactions.a_id,transactions.c_id,transactions.from,transactions.to,
                          transactions.debit,transactions.credit,transactions.netbalance, transactions.type,transactions.description,transactions.t_date,main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id  WHERE  t_date >= NOW() + INTERVAL -7 DAY  AND t_date < NOW() + INTERVAL 0 DAY GROUP BY day(t_date) ORDER BY day(t_date)");
                        //   $stmt->bind_param("i", $c_id);
                          $stmt->execute();
                          $stmt->bind_result($day,$t_id,$a_id,$c_id,$from,$to,$debit,$credit,$netbalance,$type,$description,$t_date,$name);
                
                  $cat = array();
                         while ($stmt->fetch()) {
                             $test = array();
                        $test['day'] = $day;
                        $test['t_id'] = $t_id;
                        $test['a_id'] = $a_id;
                        $test['c_id'] = $c_id;
                        $test['from'] = $from;
                        $test['to'] = $to;
                        $test['debit'] = $debit;
                        $test['credit'] = $credit;
                        $test['netbalance'] = $netbalance;
                        $test['c_id'] = $c_id;
                        $test['type'] = $type;
                        $test['description'] = $description;
                        $test['t_date'] = $t_date;
                        $test['name'] = $name;
                           array_push($cat, $test);
                          }
                          return $cat;
                    }
                
                    if ($ide == 2)
                    {                                //   Total trasactions details by last 7 Month
                           $stmt = $this->con->prepare ("SELECT date_format(t_date,'%M') as month,date_format(t_date,'%Y') as year, transactions.t_id,transactions.a_id,transactions.c_id,transactions.from,transactions.to,
                           transactions.debit,transactions.credit,transactions.netbalance, transactions.type,transactions.description,transactions.t_date,main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE t_date >= NOW()-INTERVAL 7 month GROUP BY year(t_date),month(t_date) ORDER BY year(t_date),month(t_date)");
                        //    $stmt->bind_param("i", $c_id);
                           $stmt->execute();
                           $stmt->bind_result($month, $year ,$t_id,$a_id,$c_id,$from,$to,$debit,$credit,$netbalance,$type,$description,$t_date,$name);
                
                             $cat = array();
                                    while ($stmt->fetch()) {
                                        $test = array();
                                        $test['ide'] = 1 ;
                                        $test['month'] = $month;
                                        $test['year'] = $year ;
                                        $test['t_id'] = $t_id;
                                        $test['a_id'] = $a_id;
                                        $test['c_id'] = $c_id;
                                        $test['from'] = $from;
                                        $test['to'] = $to;
                                        $test['debit'] = $debit;
                                        $test['credit'] = $credit;
                                        $test['netbalance'] = $netbalance;
                                        $test['c_id'] = $c_id;
                                        $test['type'] = $type;
                                        $test['description'] = $description;
                                        $test['t_date'] = $t_date;
                                        $test['name'] = $name;
                
                            array_push($cat, $test);
                           }
                           return $cat;
                    }
                    if ($ide == 3)
                    {                        //   Total Installments details by last 7 days
                    $stmt = $this->con->prepare ("SELECT DAYNAME(installments.date) as day,a_student.id,a_student.name,a_student.contact_no,a_student.address,a_student.course,a_student.c_duration,a_student.total_fee,a_student.advance,a_student.installment_no,a_student.st_status,a_student.status,installments.i_id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.date >= NOW() + INTERVAL -7 DAY AND installments.date < NOW() + INTERVAL 0 DAY GROUP BY day(installments.date) ORDER BY day(installments.date)");
                    // $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($day,  $id, $name, $contact_no, $address,$course, $c_duration, $total_fee, $advance, $installment_no, $st_status, $status,$i_id,$c_id, $i_amount,$remaning_payment, $date, $installmentNo);
                
                  $cat = array();
                         while ($stmt->fetch()) {
                             $test = array();
                             $test['ide'] = 2;
                             $test['day'] = $day;
                             $test['id'] = $id ;
                             $test['name'] = $name ;
                             $test['contact_no'] = $contact_no ;
                             $test['address'] = $address ;
                             $test['course'] = $course ;
                             $test['c_duration'] = $c_duration ;
                             $test['total_fee'] = $total_fee ;
                             $test['advance'] = $advance;
                             $test['installment_no'] = $installment_no ;
                             $test['st_status'] = $st_status ;
                             $test['status'] = $status ;
                             $test['i_id'] = $i_id;
                             $test['c_id'] = $c_id;
                             $test['i_amount'] = $i_amount ;
                             $test['remaning_payment'] = $remaning_payment ;
                             $test['date'] = $date;
                             $test['installmentNo'] = $installmentNo;
                
                 array_push($cat, $test);
                }
                return $cat;
                    }
                    if ($ide == 4)
                    {                        //   Total Installments revenue details by last 7 Months
                    $stmt = $this->con->prepare ("SELECT date_format(installments.date,'%M') as month,date_format(installments.date,'%Y') as year ,a_student.id,a_student.name,a_student.contact_no,a_student.address,a_student.course,a_student.c_duration,a_student.total_fee,a_student.advance,
                    a_student.installment_no,a_student.st_status,a_student.status,installments.i_id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.date >= NOW()-INTERVAL 7 month GROUP BY year(installments.date),month(installments.date) ORDER BY year(installments.date),month(installments.date)");
                    // $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month, $year , $id, $name, $contact_no, $address,$course, $c_duration, $total_fee,
                 $advance, $installment_no, $st_status, $status, $i_id,$c_id, $i_amount,$remaning_payment, $date, $installmentNo);
                
                $cat = array();
                       while ($stmt->fetch()) {
                           $test = array();
                           $test['ide'] = 3;
                           $test['month'] = $month;
                           $test['year'] = $year ;
                           $test['id'] = $id ;
                           $test['name'] = $name ;
                           $test['contact_no'] = $contact_no ;
                           $test['address'] = $address ;
                           $test['course'] = $course ;
                           $test['c_duration'] = $c_duration ;
                           $test['total_fee'] = $total_fee ;
                           $test['advance'] = $advance;
                           $test['installment_no'] = $installment_no;
                           $test['st_status'] = $st_status ;
                           $test['status'] = $status ;
                           $test['i_id'] = $i_id;
                           $test['c_id'] = $c_id;
                           $test['i_amount'] = $i_amount ;
                           $test['remaning_payment'] = $remaning_payment ;
                           $test['date'] = $date;
                           $test['installmentNo'] = $installmentNo;
                
                 array_push($cat, $test);
                }
                return $cat;
                    }
                    // seconde
                }
                else{
                    if($ide == 1)
                    {     
                          $stmt = $this->con->prepare ("SELECT DAYNAME(transactions.t_date) as day, transactions.t_id,transactions.a_id,transactions.c_id,transactions.from,transactions.to, transactions.debit,transactions.credit,transactions.netbalance,
                           transactions.type,transactions.description,transactions.t_date,main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE transactions.c_id=? AND t_date >= NOW() + INTERVAL -7 DAY AND t_date < NOW() + INTERVAL 0 DAY GROUP BY day(t_date) ORDER BY day(t_date)");
                          $stmt->bind_param("i", $c_id);
                          $stmt->execute();
                          $stmt->bind_result($day,$t_id,$a_id,$c_id,$from,$to,$debit,$credit,$netbalance,$type,$description,$t_date,$name);
                  $cat = array();
                         while ($stmt->fetch()) {
                             $test = array();
                             $test['day'] = $day;
                             $test['t_id'] = $t_id;
                             $test['a_id'] = $a_id;
                             $test['c_id'] = $c_id;
                             $test['from'] = $from;
                             $test['to'] = $to;
                             $test['debit'] = $debit;
                             $test['credit'] = $credit;
                             $test['netbalance'] = $netbalance;
                             $test['c_id'] = $c_id;
                             $test['type'] = $type;
                             $test['description'] = $description;
                             $test['t_date'] = $t_date;
                             $test['name'] = $name;
                           array_push($cat, $test);
                          }
                          return $cat;
                    }
                
                    if ($ide == 2)
                    {                                //   Total transactions details by last 7 Month
                           $stmt = $this->con->prepare ("                        
                           SELECT date_format(t_date,'%M') as month,date_format(t_date,'%Y') as year, transactions.t_id,transactions.a_id,transactions.c_id,transactions.from,transactions.to, transactions.debit,transactions.credit,transactions.netbalance, transactions.type,transactions.description,transactions.t_date,main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE transactions.c_id=? AND t_date >= NOW()-INTERVAL 7 month GROUP BY year(t_date),month(t_date) ORDER BY year(t_date),month(t_date)");
                           $stmt->bind_param("i",$c_id);
                           $stmt->execute();
                           $stmt->bind_result($month, $year ,$t_id,$a_id,$c_id,$from,$to,$debit,$credit,$netbalance,$type,$description,$t_date,$name);
                
                             $cat = array();
                                    while ($stmt->fetch()) {
                                        $test = array();
                                        $test['ide'] = 1 ;
                                        $test['month'] = $month;
                                        $test['year'] = $year ;
                                        $test['t_id'] = $t_id;
                                        $test['a_id'] = $a_id;
                                        $test['c_id'] = $c_id;
                                        $test['from'] = $from;
                                        $test['to'] = $to;
                                        $test['debit'] = $debit;
                                        $test['credit'] = $credit;
                                        $test['netbalance'] = $netbalance;
                                        $test['c_id'] = $c_id;
                                        $test['type'] = $type;
                                        $test['description'] = $description;
                                        $test['t_date'] = $t_date;
                                        $test['name'] = $name;
                
                            array_push($cat, $test);
                           }
                           return $cat;
                    }
                    if ($ide == 3)
                    {                        //   Total Installments details by last 7 days
                    $stmt = $this->con->prepare ("SELECT DAYNAME(installments.date) as day,a_student.id,a_student.name,a_student.contact_no,a_student.address,a_student.course,a_student.c_duration,a_student.total_fee,a_student.advance,a_student.installment_no,
                    a_student.st_status,a_student.status,installments.i_id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.c_id=? AND installments.date >= NOW() + INTERVAL -7 DAY AND installments.date < NOW() + INTERVAL 0 DAY GROUP BY day(installments.date) ORDER BY day(installments.date)");
                    $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($day,  $id, $name, $contact_no, $address,$course, $c_duration, $total_fee, $advance, $installment_no, $st_status, $status,$i_id,$c_id, $i_amount,$remaning_payment, $date, $installmentNo);
                
                  $cat = array();
                         while ($stmt->fetch()) {
                             $test = array();
                             $test['ide'] = 2;
                             $test['day'] = $day;
                             $test['id'] = $id ;
                             $test['name'] = $name ;
                             $test['contact_no'] = $contact_no ;
                             $test['address'] = $address ;
                             $test['course'] = $course ;
                             $test['c_duration'] = $c_duration ;
                             $test['total_fee'] = $total_fee ;
                             $test['advance'] = $advance;
                             $test['installment_no'] = $installment_no ;
                             $test['st_status'] = $st_status ;
                             $test['status'] = $status ;
                             $test['i_id'] = $i_id;
                             $test['c_id'] = $c_id;
                             $test['i_amount'] = $i_amount ;
                             $test['remaning_payment'] = $remaning_payment ;
                             $test['date'] = $date;
                             $test['installmentNo'] = $installmentNo;
                
                 array_push($cat, $test);
                }
                return $cat;
                    }
                    if ($ide == 4)
                    {                        //   Total Installments revenue details by last 7 Months
                    $stmt = $this->con->prepare ("SELECT date_format(installments.date,'%M') as month,date_format(installments.date,'%Y') as year ,a_student.id,a_student.name,a_student.contact_no,a_student.address,a_student.course,a_student.c_duration,a_student.total_fee,a_student.advance,
                    a_student.installment_no,a_student.st_status,a_student.status,
                    installments.i_id,installments.c_id,installments.i_amount,installments.remaning_payment,installments.date,installments.installmentNo FROM installments JOIN a_student ON installments.id = a_student.id WHERE installments.c_id=? AND installments.date >= NOW()-INTERVAL 7 month GROUP BY year(installments.date),month(installments.date) ORDER BY year(installments.date),month(installments.date)");
                    $stmt->bind_param("i", $c_id);
                $stmt->execute();
                $stmt->bind_result($month, $year , $id, $name, $contact_no, $address,$course, $c_duration, $total_fee,
                 $advance, $installment_no, $st_status, $status, $i_id,$c_id, $i_amount,$remaning_payment, $date, $installmentNo);
                
                $cat = array();
                       while ($stmt->fetch()) {
                           $test = array();
                           $test['ide'] = 3;
                           $test['month'] = $month;
                           $test['year'] = $year ;
                           $test['id'] = $id ;
                           $test['name'] = $name ;
                           $test['contact_no'] = $contact_no ;
                           $test['address'] = $address ;
                           $test['course'] = $course ;
                           $test['c_duration'] = $c_duration ;
                           $test['total_fee'] = $total_fee ;
                           $test['advance'] = $advance;
                           $test['installment_no'] = $installment_no;
                           $test['st_status'] = $st_status ;
                           $test['status'] = $status ;
                           $test['i_id'] = $i_id;
                           $test['c_id'] = $c_id;
                           $test['i_amount'] = $i_amount ;
                           $test['remaning_payment'] = $remaning_payment ;
                           $test['date'] = $date;
                           $test['installmentNo'] = $installmentNo;
                
                 array_push($cat, $test);
                }
                return $cat;
                    }
                }
          }


        //   select student by course done
            function getstudentbycourse($course,$c_id)
            {
                if($c_id ==3){
                    $cat3 = array();    
                    $stmt = $this->con->prepare("SELECT `id`, `c_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`,
                     `course`, `c_duration`, `a_month`, `upcoming_installment`, `ad_date`, `total_fee`, `installment_no`,
                      `per_installment`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status`
                       FROM `a_student` WHERE course = ?");
                    $stmt->bind_param("s", $course);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id,$name, $f_name, $st_gender, $contact_no, $address,$reference,
                     $cnic, $course, $c_duration,$a_month,$upcoming_installment,
                     $ad_date,$total_fee, $installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount, $status, $st_status);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['id'] = $id;
                $data['c_id'] = $c_id;
                $data['name'] = $name;
                $data['f_name'] = $f_name;
                $data['st_gender'] = $st_gender;
                $data['contact_no'] = $contact_no;
                $data['address'] = $address;
                $data['reference'] = $reference;
                $data['cnic'] = $cnic;
                $data['course'] = $course;
                $data['c_duration'] = $c_duration;
                $data['a_month'] = $a_month;
                $data['upcoming_installment'] = $upcoming_installment;
                $data['ad_date'] = $ad_date;
                $data['total_fee'] = $total_fee;
                $data['installment_no'] = $installment_no;
                $data['per_installment'] = $per_installment;
                $data['first_installment_no'] = $first_installment_no;
                $data['advance'] = $advance;
                $data['remaning_amount'] = $remaning_amount;
                $data['status'] = $status;
                $data['st_status'] = $st_status;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                return $cat3;
                }
                else{
                    $cat3 = array();    
                    $stmt = $this->con->prepare("SELECT `id`, `c_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`,
                    `course`, `c_duration`, `a_month`, `upcoming_installment`, `ad_date`, `total_fee`, `installment_no`,
                     `per_installment`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status`
                      FROM `a_student` WHERE course = ? AND c_id = ?");
                    $stmt->bind_param("si", $course,$c_id);
                    $stmt->execute();
                    $stmt->bind_result($id,$c_id,$name, $f_name, $st_gender, $contact_no, $address,$reference,
                    $cnic, $course, $c_duration,$a_month,$upcoming_installment,
                    $ad_date,$total_fee, $installment_no,$per_installment,$first_installment_no, $advance,$remaning_amount, $status, $st_status);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['id'] = $id;
                $data['c_id'] = $c_id;
                $data['name'] = $name;
                $data['f_name'] = $f_name;
                $data['st_gender'] = $st_gender;
                $data['contact_no'] = $contact_no;
                $data['address'] = $address;
                $data['reference'] = $reference;
                $data['cnic'] = $cnic;
                $data['course'] = $course;
                $data['c_duration'] = $c_duration;
                $data['a_month'] = $a_month;
                $data['upcoming_installment'] = $upcoming_installment;
                $data['ad_date'] = $ad_date;
                $data['total_fee'] = $total_fee;
                $data['installment_no'] = $installment_no;
                $data['per_installment'] = $per_installment;
                $data['first_installment_no'] = $first_installment_no;
                $data['advance'] = $advance;
                $data['remaning_amount'] = $remaning_amount;
                $data['status'] = $status;
                $data['st_status'] = $st_status;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                return $cat3;
                }
            }


        //   select student by  monthly fee status
            // function getstudentbystatus($st_status)
            // {
            // $cat3 = array();    
            //     $stmt = $this->con->prepare("SELECT  a_student.id ,a_student.name,a_student.f_name,a_student.st_gender,
            //     a_student.contact_no,a_student.address,a_student.reference,a_student.cnic,a_student.course,a_student.c_duration,
            //     a_student.ad_date, a_student.total_fee,a_student.installment_no,a_student.advance,a_student.status,a_student.st_status FROM a_student WHERE st_status = ?");
            //     $stmt->bind_param("s", $st_status);
            //     $stmt->execute();
            //     $stmt->bind_result($id,$name, $f_name, $st_gender, $contact_no, $address,$reference, $cnic, $course, $c_duration,
            //      $ad_date,$total_fee, $installment_no, $advance, $status, $st_status);
            // $cat2 = array();
            // while ($stmt->fetch()) {
            // $data = array();
            // $data['id'] = $id;
            // $data['name'] = $name;
            // $data['f_name'] = $f_name;
            // $data['st_gender'] = $st_gender;
            // $data['contact_no'] = $contact_no;
            // $data['address'] = $address;
            // $data['reference'] = $reference;
            // $data['cnic'] = $cnic;
            // $data['course'] = $course;
            // $data['c_duration'] = $c_duration;
            // $data['ad_date'] = $ad_date;
            // $data['total_fee'] = $total_fee;
            // $data['installment_no'] = $installment_no;
            // $data['advance'] = $advance;
            // $data['status'] = $status;
            // $data['st_status'] = $st_status;
            // array_push($cat2, $data);
            // }
            // array_push($cat3, $cat2);
            // return $cat3;
            // }


           // Account Page Api start

                        // Get Main Account by a_id
            // function getMainAcct($a_id,$c_id) {
            //     $stmt = $this->con->prepare("SELECT * FROM `main_account` WHERE `a_id`=?");
            //     $stmt->bind_param("i", $a_id);
            //     $stmt->execute();
            //     $stmt->bind_result($a_id, $name, $netbalance);
            //     $cat = array();
            //     while ($stmt->fetch()) {
            //         $test = array();
            //         $test['a_id'] = $a_id;
            //         $test['name'] = $name;
            //         $test['netbalance'] = $netbalance;
            
            //         array_push($cat, $test);
            //     }
            //     return $cat;
            // }
                 // Update Main Account netbalance
            function updateMainAcct($a_id,$c_id,$netbalance)
            {
                date_default_timezone_set("Asia/Karachi");
                $date = date("ymd");
                $stmt = $this->con->prepare("UPDATE `main_account` SET `netbalance`=? WHERE `a_id`=? AND c_id=?");
                $stmt->bind_param("iii", $netbalance,$a_id,$c_id);
                if ($stmt->execute()) {
            
                    return PROFILE_CREATED;
                }
                return PROFILE_NOT_CREATED;
            }
            // Get Netbalance of Main Accounts done
            function getnetbalanceMainAcct($a_id,$c_id) {
                if($c_id == 3){
                    $stmt = $this->con->prepare("SELECT netbalance,c_id FROM main_account where `a_id`=?");
                    $stmt->bind_param("i", $a_id);
                    $stmt->execute();
                    $stmt->bind_result($netbalance,$c_id);
                    $stmt->fetch();
                    return $netbalance;
                }
                else{
                    $stmt = $this->con->prepare("SELECT `netbalance` FROM `main_account` WHERE a_id = ? AND c_id =?");
                    $stmt->bind_param("ii", $a_id,$c_id);
                    $stmt->execute();
                    $stmt->bind_result($netbalance);
                    $stmt->fetch();
                    return $netbalance;
                }
            }
                        // Get Main Account by a_id 
            function getMainAcct($c_id) {
                if($c_id == 3){
                    $stmt = $this->con->prepare("SELECT `a_id`,`name`,`netbalance` FROM `main_account`");
                    // $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($a_id, $name, $netbalance);
                    $cat = array();
                    while ($stmt->fetch()) {
                        $test = array();
                        $test['a_id'] = $a_id;
                        $test['name'] = $name;
                        $test['netbalance'] = $netbalance;
                
                        array_push($cat, $test);
                    }
                    return $cat;
                }
                else{
                    $stmt = $this->con->prepare("SELECT `a_id`,`name`,`netbalance` FROM `main_account` WHERE `c_id`=?");
                    $stmt->bind_param("i", $c_id);
                    $stmt->execute();
                    $stmt->bind_result($a_id, $name, $netbalance);
                    $cat = array();
                    while ($stmt->fetch()) {
                        $test = array();
                        $test['a_id'] = $a_id;
                        $test['name'] = $name;
                        $test['netbalance'] = $netbalance;
                
                        array_push($cat, $test);
                    }
                    return $cat;
                }
            }
                    // Insert Transactions
            function transactions($a_id,$c_id, $from, $to, $debit, $credit,$netbalance, $type, $description,$other)
            {
                date_default_timezone_set("Asia/Karachi");
                $t_date = date("ymd");
                $stmt = $this->con->prepare("INSERT INTO `transactions`(`a_id`, `c_id`, `from`, `to`, `debit`, `credit`, `netbalance`, `type`, `description`, `t_date`, `other`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iiiiiiissss", $a_id,$c_id, $from, $to, $debit, $credit , $netbalance, $type, $description,$t_date,$other);
                if ($stmt->execute()) {
            
                    return PROFILE_CREATED;
                }
                return PROFILE_NOT_CREATED;
            }

                    // Get Transactions by a_id done
        function getTransactions($a_id,$c_id) {
            if($c_id == 3){
                $stmt = $this->con->prepare("SELECT `t_id`,`a_id`,`c_id`,`from`,`to`,`debit`,`credit`,`netbalance`,`type`,`description`,`t_date` FROM `transactions` WHERE `a_id`=?");
                $stmt->bind_param("i", $a_id);
                $stmt->execute();
                $stmt->bind_result($t_id, $a_id,$c_id, $from, $to, $debit, $credit, $netbalance, $type, $description, $t_date);
                $cat = array();
                while ($stmt->fetch()) {
                    $test = array();
                    $test['t_id'] = $t_id;
                    $test['a_id'] = $a_id;
                    $test['c_id'] = $c_id;
                    $test['from'] = $from;
                    $test['to'] = $to;
                    $test['debit'] = $debit;
                    $test['credit'] = $credit;
                    $test['netbalance'] = $netbalance;
                    $test['type'] = $type;
                    $test['description'] = $description;
                    $test['t_date'] = $t_date;
    
                    array_push($cat, $test);
                }
                return $cat;
            }
            else{
                $stmt = $this->con->prepare("SELECT `t_id`,`a_id`,`c_id`,`from`,`to`,`debit`,`credit`,`netbalance`,`type`,`description`,`t_date` FROM `transactions` WHERE `a_id`=? AND `c_id`=?");
                $stmt->bind_param("ii", $a_id,$c_id);
                $stmt->execute();
                $stmt->bind_result($t_id, $a_id,$c_id, $from, $to, $debit, $credit, $netbalance, $type, $description, $t_date);
                $cat = array();
                while ($stmt->fetch()) {
                    $test = array();
                    $test['t_id'] = $t_id;
                    $test['a_id'] = $a_id;
                    $test['c_id'] = $c_id;
                    $test['from'] = $from;
                    $test['to'] = $to;
                    $test['debit'] = $debit;
                    $test['credit'] = $credit;
                    $test['netbalance'] = $netbalance;
                    $test['type'] = $type;
                    $test['description'] = $description;
                    $test['t_date'] = $t_date;
    
                    array_push($cat, $test);
                }
                return $cat;
            }
        }
        // gettransactionsbymainaccount
            // function gettransactionsbymainaccount($a_id,$c_id,$type)
            // {
            // $cat3 = array();
            //     $stmt = $this->con->prepare("SELECT transactions.t_id, transactions.a_id,transactions.c_id, transactions.debit,
            //      transactions.credit, transactions.netbalance, transactions.type, transactions.description, transactions.t_date, main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE transactions.a_id = ? AND transactions.type = ? AND transactions.c_id=?");
            //     $stmt->bind_param("iis", $a_id,$c_id, $type);
            //     $stmt->execute();
            //     $stmt->bind_result($t_id, $a_id,$c_id, $debit, $credit, $netbalance, $type, $description, $t_date, $name);
            // $cat = array();
            // while ($stmt->fetch()) {
            // $data = array();
            // $data['t_id'] = $t_id;
            // $data['a_id'] = $a_id;
            // $data['c_id'] = $c_id;
            // $data['debit'] = $debit;
            // $data['credit'] = $credit;
            // $data['netbalance'] = $netbalance;
            // $data['type'] = $type;
            // $data['description'] = $description;
            // $data['t_date'] = $t_date;
            // $data['name'] = $name;
            // array_push($cat, $data);
            // }
            // array_push($cat3, $cat);
            // $stmt = $this->con->prepare("SELECT SUM(debit) as total_debit FROM transactions WHERE a_id = ? AND type = ? AND c_id=?");
            // $stmt->bind_param("iis", $a_id,$c_id, $type);
            // $stmt->execute();
            // $stmt->bind_result($total_debit);
            // $cat2 = array();
            // while ($stmt->fetch()) {
            // $data = array();
            // $data['total_debit'] = $total_debit;
            // array_push($cat2, $data);
            // }
            // array_push($cat3, $cat2);
            // $stmt = $this->con->prepare("SELECT SUM(credit) as total_credit FROM transactions WHERE a_id = ? AND type = ? AND c_id=?");
            // $stmt->bind_param("iis", $a_id,$c_id, $type);
            // $stmt->execute();
            // $stmt->bind_result($total_credit);
            // $cat2 = array();
            // while ($stmt->fetch()) {
            // $data = array();
            // $data['total_credit'] = $total_credit;
            // array_push($cat2, $data);
            // }
            // array_push($cat3, $cat2);
            // $stmt = $this->con->prepare("SELECT netbalance FROM transactions where t_id = (select MAX(t_id) from transactions WHERE a_id = ? AND type = ?) AND c_id=?");
            // $stmt->bind_param("iis", $a_id,$c_id, $type);
            // $stmt->execute();
            // $stmt->bind_result($netbalance);
            // $cat2 = array();
            // while ($stmt->fetch()) {
            // $data = array();
            // $data['netbalance'] = $netbalance;
            // array_push($cat2, $data);
            // }
            // array_push($cat3, $cat2);

            // return $cat3;
            // }

            function gettransactionsbymainaccount($a_id,$type, $c_id)
            {
                if($c_id == 3){
                    $cat3 = array();
                    $stmt = $this->con->prepare("SELECT transactions.t_id, transactions.a_id,transactions.c_id, transactions.debit,
                     transactions.credit, transactions.netbalance, transactions.type, transactions.description, transactions.t_date,
                      main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE transactions.a_id = ? AND transactions.type =?");
                    $stmt->bind_param("is", $a_id,$type);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $a_id,$c_id, $debit, $credit, $netbalance, $type, $description, $t_date, $name);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['t_id'] = $t_id;
                $data['a_id'] = $a_id;
                $data['c_id'] = $c_id;
                $data['debit'] = $debit;
                $data['credit'] = $credit;
                $data['netbalance'] = $netbalance;
                $data['type'] = $type;
                $data['description'] = $description;
                $data['t_date'] = $t_date;
                $data['name'] = $name;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                $stmt = $this->con->prepare("SELECT SUM(debit) as total_debit FROM transactions WHERE a_id = ? AND type = ?");
                $stmt->bind_param("is", $a_id,$type);
                $stmt->execute();
                $stmt->bind_result($total_debit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_debit'] = $total_debit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT SUM(credit) as total_credit FROM transactions WHERE a_id = ? AND type = ? ");
                $stmt->bind_param("is", $a_id,$type);
                $stmt->execute();
                $stmt->bind_result($total_credit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_credit'] = $total_credit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT netbalance FROM transactions where t_id = (select MAX(t_id) from transactions WHERE a_id = ? AND type = ?)");
                $stmt->bind_param("is", $a_id,$type);
                $stmt->execute();
                $stmt->bind_result($netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['netbalance'] = $netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
                else{
                    $cat3 = array();
                    $stmt = $this->con->prepare("SELECT transactions.t_id, transactions.a_id,transactions.c_id, transactions.debit,
                     transactions.credit, transactions.netbalance, transactions.type, transactions.description, transactions.t_date,
                      main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id WHERE transactions.a_id = ? AND transactions.type =? AND transactions.c_id=?");
                    $stmt->bind_param("isi", $a_id,$type,$c_id);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $a_id,$c_id, $debit, $credit, $netbalance, $type, $description, $t_date, $name);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['t_id'] = $t_id;
                $data['a_id'] = $a_id;
                $data['c_id'] = $c_id;
                $data['debit'] = $debit;
                $data['credit'] = $credit;
                $data['netbalance'] = $netbalance;
                $data['type'] = $type;
                $data['description'] = $description;
                $data['t_date'] = $t_date;
                $data['name'] = $name;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                $stmt = $this->con->prepare("SELECT SUM(debit) as total_debit FROM transactions WHERE a_id = ? AND type = ? AND c_id=?");
                $stmt->bind_param("isi", $a_id,$type,$c_id);
                $stmt->execute();
                $stmt->bind_result($total_debit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_debit'] = $total_debit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT SUM(credit) as total_credit FROM transactions WHERE a_id = ? AND type = ? AND c_id=?");
                $stmt->bind_param("isi", $a_id,$type,$c_id);
                $stmt->execute();
                $stmt->bind_result($total_credit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_credit'] = $total_credit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT netbalance FROM transactions where t_id = (select MAX(t_id) from transactions WHERE a_id = ? AND type = ? AND c_id=?)");
                $stmt->bind_param("isi", $a_id,$type,$c_id);
                $stmt->execute();
                $stmt->bind_result($netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['netbalance'] = $netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
            }

            // gettransactionsbyexpense
            function gettransactionsbyexpense($a_id,$type,$description,$c_id)
            {
                if($c_id == 3){
                    $cat3 = array();
                    $stmt = $this->con->prepare("SELECT transactions.t_id, transactions.a_id,transactions.c_id, transactions.debit, transactions.credit, transactions.netbalance, transactions.type,
                    transactions.description, transactions.t_date, main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id
                    WHERE transactions.a_id = ? AND transactions.type =? AND transactions.description = ?");
                    $stmt->bind_param("iss", $a_id,$type,$description);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $a_id,$c_id, $debit, $credit, $netbalance, $type, $description, $t_date, $name);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['t_id'] = $t_id;
                $data['a_id'] = $a_id;
                $data['c_id'] = $c_id;
                $data['debit'] = $debit;
                $data['credit'] = $credit;
                $data['netbalance'] = $netbalance;
                $data['type'] = $type;
                $data['description'] = $description;
                $data['t_date'] = $t_date;
                $data['name'] = $name;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                $stmt = $this->con->prepare("SELECT SUM(debit) as total_debit FROM transactions WHERE a_id = ? AND type = ? AND description = ?");
                $stmt->bind_param("iss", $a_id, $type, $description);
                $stmt->execute();
                $stmt->bind_result($total_debit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_debit'] = $total_debit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT SUM(credit) as total_credit FROM transactions WHERE a_id = ? AND type = ? AND description = ? ");
                $stmt->bind_param("iss", $a_id, $type, $description);
                $stmt->execute();
                $stmt->bind_result($total_credit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_credit'] = $total_credit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT netbalance FROM transactions where t_id = (select MAX(t_id) from transactions WHERE a_id = ? AND type = ? AND description = ?)");
                $stmt->bind_param("iss", $a_id, $type, $description);
                $stmt->execute();
                $stmt->bind_result($netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['netbalance'] = $netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
                else{
                    $cat3 = array();
                    $stmt = $this->con->prepare("SELECT transactions.t_id, transactions.a_id,transactions.c_id, transactions.debit, transactions.credit, transactions.netbalance, transactions.type,
                    transactions.description, transactions.t_date, main_account.name FROM transactions JOIN main_account ON transactions.a_id = main_account.a_id
                    WHERE transactions.a_id = ? AND transactions.type =? AND transactions.description = ? AND transactions.c_id=?");
                    $stmt->bind_param("issi", $a_id,$type,$description,$c_id);
                    $stmt->execute();
                    $stmt->bind_result($t_id, $a_id,$c_id, $debit, $credit, $netbalance, $type, $description, $t_date, $name);
                $cat = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['t_id'] = $t_id;
                $data['a_id'] = $a_id;
                $data['c_id'] = $c_id;
                $data['debit'] = $debit;
                $data['credit'] = $credit;
                $data['netbalance'] = $netbalance;
                $data['type'] = $type;
                $data['description'] = $description;
                $data['t_date'] = $t_date;
                $data['name'] = $name;
                array_push($cat, $data);
                }
                array_push($cat3, $cat);
                $stmt = $this->con->prepare("SELECT SUM(debit) as total_debit FROM transactions WHERE a_id = ? AND type = ? AND description = ? AND c_id=?");
                $stmt->bind_param("issi", $a_id, $type, $description,$c_id);
                $stmt->execute();
                $stmt->bind_result($total_debit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_debit'] = $total_debit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT SUM(credit) as total_credit FROM transactions WHERE a_id = ? AND type = ? AND description = ? AND c_id=?");
                $stmt->bind_param("issi", $a_id, $type, $description,$c_id);
                $stmt->execute();
                $stmt->bind_result($total_credit);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['total_credit'] = $total_credit;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
                $stmt = $this->con->prepare("SELECT netbalance FROM transactions where t_id = (select MAX(t_id) from transactions WHERE a_id = ? AND type = ? AND description = ? AND c_id=?)");
                $stmt->bind_param("issi", $a_id, $type, $description,$c_id);
                $stmt->execute();
                $stmt->bind_result($netbalance);
                $cat2 = array();
                while ($stmt->fetch()) {
                $data = array();
                $data['netbalance'] = $netbalance;
                array_push($cat2, $data);
                }
                array_push($cat3, $cat2);
    
                return $cat3;
                }
            }


                    
            // function get_alldata_graph($c_id)
            // {
            //     if($c_id == 3){
            //         $cat3 = array();                //   Total expense by last 7 days
            //         $stmt = $this->con->prepare("select DAYNAME(t_date) as day,transactions.c_id, SUM(netbalance) as total_netbalance from transactions WHERE t_date >= NOW() + INTERVAL -7 DAY AND t_date <  NOW() + INTERVAL  0 DAY group by day(t_date) order by day(t_date)");
            //         // $stmt->bind_param("i", $c_id);
            //         $stmt->execute();
            //         $stmt->bind_result($day,$c_id, $total_netbalance);
            //     $cat = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['day'] = $day;
            //     $data['c_id'] = $c_id;
            //     $data['total_expense'] = $total_netbalance;
            //     array_push($cat, $data);
            //     }
            //     array_push($cat3, $cat);
            //             //   Total expense by last 7 Month
            //     $stmt = $this->con->prepare("select date_format(a_date,'%M') as month ,account.c_id,date_format(a_date,'%Y') as year ,SUM(amount) as total_expense from account WHERE a_date >= now()-interval 7 month group by year(a_date),month(a_date) order by year(a_date)");
            //     // $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($month,$c_id, $year, $total_expense);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['month'] = $month;
            //     $data['c_id'] = $c_id;
            //     $data['year'] = $year;
            //     $data['total_expense'] = $total_expense;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);        //   Total Installments  by last 7 days
            //     $stmt = $this->con->prepare("SELECT DAYNAME(date) as day,installments.c_id, SUM(i_amount) as total_installments FROM installments WHERE date >= NOW() + INTERVAL -7 DAY AND date < NOW() + INTERVAL 0 DAY GROUP BY day(date) ORDER BY day(date)");
            //     // $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($day,$c_id, $total_installments);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['day'] = $day;
            //     $data['c_id'] = $c_id;
            //     $data['total_installments'] = $total_installments;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);   //   Total Installments by last 7 Month
            //     $stmt = $this->con->prepare("SELECT date_format(date ,'%M') as month,installments.c_id,date_format(date ,'%Y') as year, SUM(i_amount) as total_installments FROM installments WHERE date >= NOW()-INTERVAL 7 month GROUP BY year(date), month(date) ORDER BY year(date),month(date)");
            //     // $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($month,$c_id, $year , $total_installments);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['month'] = $month;
            //     $data['c_id'] = $c_id;
            //     $data['year'] = $year;
            //     $data['total_installments'] = $total_installments;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);
    
            //     return $cat3;
            //     }
            //     else{
            //         $cat3 = array();                //   Total expense by last 7 days
            //         $stmt = $this->con->prepare("select DAYNAME(a_date) as day,account.c_id, SUM(amount) as total_expense from account WHERE c_id =? AND a_date >= NOW() + INTERVAL -7 DAY AND a_date <  NOW() + INTERVAL  0 DAY group by day(a_date) order by day(a_date)");
            //         $stmt->bind_param("i", $c_id);
            //         $stmt->execute();
            //         $stmt->bind_result($day,$c_id, $total_expense);
            //     $cat = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['day'] = $day;
            //     $data['c_id'] = $c_id;
            //     $data['total_expense'] = $total_expense;
            //     array_push($cat, $data);
            //     }
            //     array_push($cat3, $cat);
            //             //   Total expense by last 7 Month
            //     $stmt = $this->con->prepare("select date_format(a_date,'%M') as month ,account.c_id,date_format(a_date,'%Y') as year ,SUM(amount) as total_expense from account WHERE c_id=? AND a_date >= now()-interval 7 month group by year(a_date),month(a_date) order by year(a_date)");
            //     $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($month,$c_id, $year, $total_expense);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['month'] = $month;
            //     $data['c_id'] = $c_id;
            //     $data['year'] = $year;
            //     $data['total_expense'] = $total_expense;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);        //   Total Installments  by last 7 days
            //     $stmt = $this->con->prepare("SELECT DAYNAME(date) as day,installments.c_id, SUM(i_amount) as total_installments FROM installments WHERE c_id=? AND date >= NOW() + INTERVAL -7 DAY AND date < NOW() + INTERVAL 0 DAY GROUP BY day(date) ORDER BY day(date)");
            //     $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($day,$c_id, $total_installments);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['day'] = $day;
            //     $data['c_id'] = $c_id;
            //     $data['total_installments'] = $total_installments;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);   //   Total Installments by last 7 Month
            //     $stmt = $this->con->prepare("SELECT date_format(date ,'%M') as month,installments.c_id,date_format(date ,'%Y') as year, SUM(i_amount) as total_installments FROM installments WHERE c_id=? AND date >= NOW()-INTERVAL 7 month GROUP BY year(date), month(date) ORDER BY year(date),month(date)");
            //     $stmt->bind_param("i", $c_id);
            //     $stmt->execute();
            //     $stmt->bind_result($month,$c_id, $year , $total_installments);
            //     $cat2 = array();
            //     while ($stmt->fetch()) {
            //     $data = array();
            //     $data['month'] = $month;
            //     $data['c_id'] = $c_id;
            //     $data['year'] = $year;
            //     $data['total_installments'] = $total_installments;
            //     array_push($cat2, $data);
            //     }
            //     array_push($cat3, $cat2);
    
            //     return $cat3;
            //     }
            // }


}   

                                          