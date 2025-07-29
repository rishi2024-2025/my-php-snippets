<?php
require_once '/var/www/html/dss/vendor/autoload.php';
require_once '/var/www/html/dss/excel_reader2.php';
ini_set("memory_limit", -1);
require_once '/var/www/html/dss/include/pixie-master/vendor/autoload.php';
date_default_timezone_set('Asia/Kolkata');
include '/var/www/html/dss/include/db_con_for_extrnl_file_mailing.php';
require '/var/www/html/dss/phpmailer/class.phpmailer.php';
include '/var/www/html/dss/include/functionForCron_Job_new2.php';
class Add_company extends Myfunction
{

  public $_uid;
    public function __construct()
  {
    $to_day = date("Y-m-d H:i:s");
    //$yearkk = date('Y');
$yearkk = 2025;
    $timestamp = date("Y-m-d H:i:s");
    $day = date('l', strtotime($timestamp));

    if ($day == "Saturday" || $day == "Sunday") {
      exit;
    }

    $this->timestampnew = date("H:i:s");

    echo "kajol";
    $this->mds_server_status = 1;
    $this->special_normal_premium = 1;
    // echo "\n" .   $schedule_time="12:30:00";
    // echo "\n" .  $this->timestampnew;
    // $firstTime=strtotime($schedule_time);
    // $lastTime=strtotime($this->timestampnew);
    // $t =$lastTime -$firstTime; 
    // $K= $t/60;
    // $K=round($K);
    // echo "\ntime_count:  ".$K;
    // if( $K>=0 &&  $K <=200){  
    //   }else{ 
    //     exit;
    //   }

    $this->u_id = 103;
$week_10 = date('Y-m-d', strtotime('-11 weeks'));
    $_GET['total_checked_projects'] = "2";
    if (isset($_GET['total_checked_projects']) && !empty($_GET['total_checked_projects'])) {

      $total_checked_projects = $_POST['total_checked_projects'];
      $drafting_type = $_POST['drafting_type'];
      // $project_id_array =array(9569);
      // $project_id_array =array(9570,9569,9571,10640);
      $all_check = $_POST['all_check'];
      $first_check = $_POST['first_check'];
      $reminder_check = $_POST['reminder_check'];
      $cws_check = $_POST['cws_check'];
      $invite_check = $_POST['invite_check'];

      if ($first_check == 11 && $reminder_check == 22 && $cws_check == 33 && $invite_check == 44) {
        $this->mail_con = array('Reminder 1', 'Can We Schedule','First Mail', 'Invite 2');
      } elseif ($first_check == 11 && $reminder_check == 22 && $cws_check == 33) {
        $this->mail_con = array('Reminder 1', 'Can We Schedule','First Mail');
      } elseif ($first_check == 11 && $reminder_check == 22 && $invite_check == 44) {
        $this->mail_con = array('First Mail', 'Reminder 1', 'Invite 2');
      } elseif ($first_check == 11 && $cws_check == 33 && $invite_check == 44) {
        $this->mail_con = array('First Mail', 'Can We Schedule', 'Invite 2');
      } elseif ($reminder_check == 22 && $cws_check == 33 && $invite_check == 44) {
        $this->mail_con = array('Reminder 1', 'Can We Schedule', 'Invite 2');
      } elseif ($first_check == 11 && $reminder_check == 22) {
        $this->mail_con = array('First Mail', 'Reminder 1');
      } elseif ($first_check == 11 && $cws_check == 33) {
        $this->mail_con = array('First Mail', 'Can We Schedule');
      } elseif ($first_check == 11 && $invite_check == 44) {
        $this->mail_con = array('First Mail', 'Invite 2');
      } elseif ($reminder_check == 22 && $cws_check == 33) {
        $this->mail_con = array('Reminder 1', 'Can We Schedule');
      } elseif ($reminder_check == 22 && $invite_check == 44) {
        $this->mail_con = array('Reminder 1', 'Invite 2');
      } elseif ($cws_check == 33 && $invite_check == 44) {
        $this->mail_con = array('Can We Schedule', 'Invite 2');
      } elseif ($first_check == 11) {
        $this->mail_con = array('First Mail');
      } elseif ($reminder_check == 22) {
        $this->mail_con = array('Reminder 1');
      } elseif ($cws_check == 33) {
        $this->mail_con = array('Can We Schedule');
      } elseif ($invite_check == 44) {
        $this->mail_con = array('Invite 2');
      } else {
        // $this->mail_con= array('Reminder 1', 'Can We Schedule','First Mail','Reminder 2');
        $this->mail_con = array('Reminder 1', 'Can We Schedule','First Mail', 'Reminder 2');
      }
      $total_batch = count($project_id_array);
      $user_is_str = implode(',', $project_id_array);
      $array_value = "'" . $user_is_str . "'";
      echo "_+++++++++++++++++++++++++++++";
      $arr = QB::query(" select p.pid from projectinfo p join master_companies m on m.pid=p.pid where p.year>=$yearkk and p.status in (1,0) and p.project_status in (1,0) and p.print_online_hold_status = 0 and ((m.opted_by is not null and m.opted_by != '') or m.exception=5) and m.bulk not in(2000,5000) and (p.magid not in(51,52,53,57) or p.region_status=1) and p.region_status not in(2,3) and  special = 1 and p.pid not in (select pid from sales_project_for_cxo)  and p.pid=16284 group by p.pid ")->get();

      foreach ($arr as $project) {
        echo "\n===============>" . $pid_draft = $project->pid;

        /* proposal*/
        if ($this->mds_server_status == 1) {
          $mail_type_normal = $this->mail_con;
        } else {
          $mail_type_normal = array('Reminder 1', 'Can We Schedule','First Mail');
        }




        //$mail_type_normal = array('Reminder 1', 'Can We Schedule','First Mail');
        $process_html = '';
        if ($pid_draft > 0) {
          $res_process = QB::query("select * from emailprocess.companytype_status where project_id in($pid_draft) order by id limit 216000,6000")->get();
          if (count($res_process) > 0) {
            foreach ($res_process as $value) {
              $statusPara = $value->status;
              $proposal_type = array('Premium');

              if ($this->special_normal_premium == 1) {
                $proposal_type = array('Premium');
                $mail_type_normal = array('Reminder 1', 'Can We Schedule','First Mail');
              }


              foreach ($proposal_type as $proposal) {
                foreach ($mail_type_normal as $mail_type) {
                  // block for First Mail
                  // if($mail_type == 'First Mail'){
                  //   continue;
                  // }
                  $mail_type;
                  $proposal;
                  $cmp_type = $value->status;
                  if ($this->mds_server_status == 2) {
                    if ($cmp_type == 3 || $cmp_type == 2) {
                      $cmp_type = 0;
                    }
                  }
                  $proposal = $proposal;
                  $mail_type = $mail_type;
                  $today = date("Y-m-d");

                  // if (trim($mail_type) == 'First Mail') {
                  //   continue;
                  // }


                  if ($this->special_normal_premium == 1) {

                    if (trim($mail_type) == 'First Mail') {
                      $result_pre = QB::query("select 0 ready_to_send,t.id,t.subject,t.mail_content from special_proposal_category t where t.pid=$pid_draft and t.mail_type='$mail_type' and category_id='$cmp_type'  and t.subject!= '' and t.subject is not null and t.subject !='NULL'  limit 1")->get();

                      if(count($result_pre)==0){
                        $project_wisecond = " and proj_flag=0";
                        $check_contentpid = QB::query("select * from premium_proposal_preview_content where project_id=$pid_draft and proj_flag = 1")->get();
                        if(count($check_contentpid)>0){
                            $project_wisecond = " and proj_flag=1 and project_id=$pid_draft ";
                        }else{
                            $project_wisecond = " and proj_flag=0";
                        }
                        $result_pre = QB::query("select 0 ready_to_send,id,mail_content,subject from  premium_proposal_preview_content where coy_cover=3 and region=1 and mail_type='First Mail' and pid=2 and magazine_type ='Same Magazine' and act_deact = 0 and out_non_flag = 0  and proposal_status= 2 $project_wisecond order by rand() limit 1")->get();
                      }
                      $sub = $result_pre[0]->subject;
                    } else {
                      $n_p_pid = $pid_draft;

                      //normal premium msg content and subject
                      // $select_qry_us = QB::query("select pid from projectinfo p where pid=$pid_draft and special != 1 and (magid not in(51,52,53,57) or region_status=1) and region_status not in(2,3)")->get();
                      // if (count($select_qry_us) > 0) {
                      //   $n_p_pid = "11592";
                      // }
                      // $select_qry_europe = QB::query("select pid from projectinfo p where pid=$pid_draft and special != 1 and (p.magid=53 or p.region_status=3)")->get();
                      // if (count($select_qry_europe) > 0) {
                      //   $n_p_pid = "11593";
                      // }
                      // $select_qry_apac = QB::query("select pid from projectinfo p where pid=$pid_draft and special != 1 and (p.magid in(51,52) or p.region_status=2)")->get();
                      // if (count($select_qry_apac) > 0) {
                      //   $n_p_pid = "11594";
                      // }
                      // //end
                      // $result_pre = QB::query("select t.ready_to_send,t.id,t.subject,t.mail_content from session_content t where t.pid=$n_p_pid  and t.mail_type='$mail_type' and t.draft_name='$proposal' and t.company_type_status='3' and t.status=0 order by updateddate desc limit 1")->get();
                      // $sub = $result_pre[0]->subject;
                    }
                  } else {
                    // $result_pre = QB::query("select t.ready_to_send,t.id,t.subject,t.mail_content from session_content t where t.pid=$pid_draft and t.mail_type='$mail_type' and t.draft_name='$proposal' and t.company_type_status='$cmp_type' and t.status=0 order by updateddate desc limit 1")->get();
                    // $sub = $result_pre[0]->subject;
                  }


                  if ($sub == '' || $sub == null || count($result_pre) == 0) {
                    $project_wisecond = " and proj_flag=0";
                        $check_contentpid = QB::query("select * from premium_proposal_preview_content where project_id=$pid_draft and proj_flag = 1")->get();
                        if(count($check_contentpid)>0){
                            $project_wisecond = " and proj_flag=1 and project_id=$pid_draft ";
                        }else{
                            $project_wisecond = " and proj_flag=0";
                        }
                        echo "\n <<<<<<<<< "."select 0 ready_to_send,id,mail_content,subject from  premium_proposal_preview_content where mail_type='$mail_type' and pid=2 and act_deact = 0 and out_non_flag = 0  and proposal_status= 2 $project_wisecond order by rand() limit 1";
                        $result_pre = QB::query("select 0 ready_to_send,id,mail_content,subject from  premium_proposal_preview_content where mail_type='$mail_type' and pid=2 and act_deact = 0 and out_non_flag = 0  and proposal_status= 2 $project_wisecond order by rand() limit 1")->get();
                        $sub = $result_pre[0]->subject;
                  }
                  if ($sub != '' && $sub != null && count($result_pre) != 0) {
                    $subject = $result_pre[0]->subject;
                    $ref_id = $result_pre[0]->id;
                    $ready_to_send = $result_pre[0]->ready_to_send;

                    $message_body = stripslashes($result_pre[0]->mail_content);
                    $urlsql = "select magazine_url from dss.magazine_details where magid = (select magid from projectinfo where pid = '$pid_draft')";
                    $con14 = QB::query($urlsql);
                    $con14 = $con14->get();
                    $magurl = $con14[0]->magazine_url;
                    $project_name = self::get_project($pid_draft);
                    if (isset($_POST['campaign_code']) && !empty($_POST['campaign_code'])) {
                      $this->campaign_code = $_POST['campaign_code'];
                      $message_body = self::AppendCampaignToString($message_body);
                    }

                    $current_mag_id = self::magazine_id($pid_draft);
                    $today = date("Y-m-d");
                    $mailingProcess = trim($cmp_type);
                    $proposalType = trim($proposal);
                    $mailTypeStatus = trim($mail_type);
                    if ($mailTypeStatus != '') {
                      $whereComp = "";

                      // if ($proposalType == 'Premium') {
                      //   // $whereComp = " and ( m.opted_by is not null or m.exception=5) and m.bulk not in(2000,5000)";
                      //   $whereComp = "";
                      // } else if ($proposalType == 'Normal') {
                      //   $whereComp = " and ((m.opted_by is null or m.opted_by=0 or m.opted_by='') and ( m.exception=2 or m.exception=6 or  m.exception=0 or  m.exception=1 or  m.exception=3)) ";
                      // }
                      // $whereComp = "and ((( m.opted_by is not null or m.exception=5) and m.bulk not in(2000,5000)) or ((m.opted_by is null or m.opted_by=0 or m.opted_by='') and ( m.exception=2 or m.exception=6 or  m.exception=0 or  m.exception=1 or  m.exception=3)))";
                      $wherePastClosure = " and a.email_send_status =0";

                      $whereMailtypeClause = "and m.p3_status in('$mailingProcess')";
                        if ($mailingProcess == 3) {
                          $whereMailtypeClause = "and m.p3_status in('$mailingProcess')";
                        }
                      if ($mailingProcess == 0) {
                        $whereMailtypeClause = "and m.p3_status in('$mailingProcess',3)";
                      }

                      if ($mailTypeStatus == 'First Mail') {
                        $mailtypecon = " and (trim(a.first_senddate)='' or a.first_senddate is null or a.first_senddate='0000-00-00 00-00')";
                        $ttl_sent =  "and total_email_sent< 3";
                      } elseif ($mailTypeStatus == 'Reminder 1') {
                        $mailtypecon = " and (trim(a.rem_senddate)='' or a.rem_senddate is null or a.rem_senddate='0000-00-00 00-00') and trim(a.first_senddate)!='' and a.first_senddate is not null and a.first_senddate!='0000-00-00 00-00'";
                        $ttl_sent =  "and total_email_sent< 3";
                      } elseif ($mailTypeStatus == 'Can We Schedule') {
                        $mailtypecon = " and (trim(a.cws_senddate)='' or a.cws_senddate is null or a.cws_senddate='0000-00-00 00-00') and trim(a.first_senddate)!='' and a.first_senddate is not null and a.first_senddate!='0000-00-00 00-00' and trim(a.rem_senddate)!='' and a.rem_senddate is not null and a.rem_senddate!='0000-00-00 00-00'";
                        $ttl_sent =  "and total_email_sent< 3";
                      } elseif ($mailTypeStatus == 'Invite 2') {
                        $mailtypecon = " and (trim(a.invite2_senddate)='' or a.invite2_senddate is null or a.invite2_senddate='0000-00-00 00-00') and trim(a.cws_senddate)!='' and a.cws_senddate is not null and a.cws_senddate!='0000-00-00 00-00' and trim(a.first_senddate)!='' and a.first_senddate is not null and a.first_senddate!='0000-00-00 00-00' and trim(a.rem_senddate)!='' and a.rem_senddate is not null and a.rem_senddate!='0000-00-00 00-00'";
                        $ttl_sent =  "and total_email_sent< 3";
                      } elseif ($mailTypeStatus == 'Reminder 2') {
                        $mailtypecon = " and (trim(a.invite2_senddate)='' or a.invite2_senddate is null or a.invite2_senddate='0000-00-00 00-00') and trim(a.cws_senddate)!='' and a.cws_senddate is not null and a.cws_senddate!='0000-00-00 00-00' and trim(a.first_senddate)!='' and a.first_senddate is not null and a.first_senddate!='0000-00-00 00-00' and trim(a.rem_senddate)!='' and a.rem_senddate is not null and a.rem_senddate!='0000-00-00 00-00'";
                        $ttl_sent =  "and total_email_sent< 4";
                      }
                      $union_t = "";
                      

                      $mysqlQuery = "select m.extra_field2,m.rank,m.premium_normal,a.email_id,0 as flag,a.cid,m.exception,m.opted_by,m.bulk,(select cname from master_companies where cid=a.cid limit 1) as cname,(select curl from master_companies where cid=a.cid limit 1) as curl,a.pid,a.f_name,a.l_name,a.designation,a.p_type,a.person_type,a.child_email_id,m.batch,a.proposal_type,m.p3_status, 'First Mail' as mail_type from master_companies m join addperson_detail a on m.cid=a.cid where a.email_id!='' and a.email_id is not null and a.pl_deleted_status=0 $wherePastClosure $mailtypecon and a.pid=$pid_draft $whereComp  and m.p3_status>0 and m.p3_status=$cmp_type and m.approval!=5 $ttl_sent and  child_email_id!='' and child_email_id is not null and m.rank not in(51,52,53) and m.batch!='' and m.batch is not null   group by a.email_id $union_t";

                    //   echo '<li>kajol-->' . $mysqlQuery;




                      $get_data = QB::query($mysqlQuery);
                      $resBatchData = $get_data->get();

                      $incrCount = 0;
                      $ttl_data = count($resBatchData);
                      $session_id = self::getSession();

                      foreach ($resBatchData as $resValue) {
                        // if($resValue->extra_field2 == '1'){
                        //   $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                        //   if(count($select_stuck)==0){
                        //       $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$resValue->email_id','OT Company Blocked','$mail_type',now(),now(),3)");
                        //   }
                        //   continue;
                        // }

                        $send_flag = 0;
$premium_normal = $resValue->premium_normal;
$premium_normal = 1;
                        $proposal = $proposalType = "Premium";

                        if ($this->mds_server_status == 1) {

                          if($resValue->rank == 10 || $resValue->rank == 11 && trim($mail_type) != 'First Mail'){
                            $get_status = QB::query("select status from emailprocess.companytype_status where project_id=$pid_draft and status_name ='Rank 10'")->get();
                            if(count($get_status)>0){
                              $category = $get_status[0]->status;
                              $cmp_type = $category;
                              $mailingProcess = trim($cmp_type);
                            }
                          }else{
                            $cmp_type = $resValue->p3_status;
                            $mailingProcess = trim($cmp_type);
                          }

                        }

                        //echo 222;
                        // date_default_timezone_set('Asia/Kolkata');   
                        $today_date = date("Y-m-d H:i:s");
                        $today1 = date("Y-m-d");

                        $recevemail =  trim(addslashes($resValue->email_id));
                        $this->sender_email = $resValue->child_email_id;

                        $this->finaltime = date('h:i:s', strtotime('+5 hours 30 minutes'));

                        
                        $country_query = QB::query("select group_concat(country) as country from region_wise_country_block where blocked_flag =1")->get();
                        $result = $country_query[0]->country;
                        $country_data = str_replace(',', "','", $result);
                        $concat_country = "'".$country_data."'";
                        if ($concat_country != '') {
                          $all_regioncountry = QB::query("select * from master_companies  where  cid=$resValue->cid and country in($concat_country) ")->get();
                          if (count($all_regioncountry) > 0) {
                            $send_flag = 1;
                            echo "\n region_wise_country_block";
                            $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            if(count($select_stuck)==0){
                                $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Country Blocked','$mail_type',now(),now(),3)");
                            }
                          }
                        }

                        
                       // $all_regioncountry = QB::query("select * from master_companies  where  cid=$resValue->cid and country in('Europe','Latin America','Australia','New Zeeland') ")->get();
                        //   if (count($all_regioncountry) > 0) {
                        //     $send_flag = 1;
                        //     echo "\n region_wise_country_block";
                        //   }
                        
                        
                        


                        $outlook_condition = '';
                          $get_magid = QB::query("select magid from special_company_magid k where pid=$pid_draft and cid=$resValue->cid")->get();
                          $m_id=$get_magid[0]->magid;
                          
                            if($resValue->extra_field2 == '1'){
                            if($mailTypeStatus != 'First Mail'){
                              $left_domain_cond= "";
                              $outlook_condition = "";
                            }else{
                              // // $left_domain_cond= " and gmail_outlook_flag=1";
                              $left_domain_cond= "";
                              $outlook_condition = " and out_non_flag = 1 ";
                            }
                          }else{  
                            // // $left_domain_cond= " and gmail_outlook_flag=0";
                            $left_domain_cond= "";
                            $outlook_condition = " and out_non_flag = 0 ";
                          }

                          if($mail_type == 'First Mail'){
                            $assign_child_id = QB::query("select (select count(*) cnt from d3_compose d join projectinfo p on p.pid=d.pid where special=1 and addeddate between '$today1 00:00:00' and '$today1 23:59:59' and mail_type='First Mail' and d.sender_email=k.child_email_id) cnt, s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and k.addeddate >= '$week_10 00:00:00' and ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0  group by k.child_email_id having cnt<50 order by mail_open desc limit 1")->get();
//$assign_child_id = QB::query("select (select count(*) cnt from d3_compose d join projectinfo p on p.pid=d.pid where special=1 and addeddate between '$today1 00:00:00' and '$today1 23:59:59' and mail_type='First Mail' and d.sender_email=k.child_email_id) cnt, s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and k.addeddate >= '$week_10 00:00:00' and ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0  group by k.child_email_id having cnt<50 order by mail_open desc limit 1")->get();


                          if (count($assign_child_id) > 0) {
                            $this->magid = $assign_child_id[0]->magid;
// $magid_array = array(451, 452, 453, 454, 455, 456); 
                            // if (in_array($this->magid, $magid_array)) {
                            //   echo "\n Magazine Blocked";
                            //   $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            //   if(count($select_stuck)==0){
                            //       $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Medical Care Review Magazine Blocked.','$mail_type',now(),now(),3)");
                            //   }
                            //   continue;
                            // }
                            $current_mag_id = $this->magid;
                             $this->sender_email = $assign_child_id[0]->email;
                             $sender_email_k = $this->sender_email;
                          } else {
                            echo ">>> Limit exceeded for First Mail kajol > ".$mail_type;
                                  $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                  if(count($select_stuck)==0){
                                      $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','35 Limit exceeded or sender email not assigned.','$mail_type',now(),now(),3)");
                                  }
                                  continue;

                          }
                        }else{
                          if($mailTypeStatus != 'First Mail' && $resValue->person_type=='P1'){
                            $get_senderemail = QB::query("select sender_email from past_closures_mailing where  cid=$resValue->cid order by id desc limit 1")->get();
                            if (count($get_senderemail) > 0) {
                              $this->sender_email = $get_senderemail[0]->sender_email;
                              $assign_child_id = QB::query("select s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and  ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0 and k.child_email_id='$this->sender_email' group by k.child_email_id order by mail_open desc limit 1")->get();

//$assign_child_id = QB::query("select s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and  ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0 and k.child_email_id='$this->sender_email' group by k.child_email_id order by mail_open desc limit 1")->get();
                              if(count($assign_child_id) == 0){
                                echo ">>> Email ID not ready to send kajol > ".$mail_type;
                                $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                if(count($select_stuck)==0){
                                  $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Email ID not ready to send.','$mail_type',now(),now(),3)");
                                }
                                continue;
                              }else{
                                $this->magid = $assign_child_id[0]->magid;
                              }
                            } else {
                              $update_add = QB::query("update addperson_detail set first_senddate='',rem_senddate='',cws_senddate='',total_email_sent='' where cid=$resValue->cid and email_id='$recevemail'");
                              echo ">>> Sender Email Not Assigned";
                              continue;
                            }
                          }else if($mailTypeStatus != 'First Mail' && $resValue->person_type !='P1'){
                            $get_senderemail = QB::query("select sender_email from d3_compose where  cid=$resValue->cid and receiver_email='$recevemail'")->get();
                            if (count($get_senderemail) > 0) {
                              $this->sender_email = $get_senderemail[0]->sender_email;
                              $assign_child_id = QB::query("select s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and  ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
(testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=6 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0 and k.child_email_id='$this->sender_email' group by k.child_email_id order by mail_open desc limit 1")->get();

//$assign_child_id = QB::query("select s.magid,k.child_email_id as email from special_company_magid s join master_companies m on m.cid=s.cid join special_child_details k on k.magid=s.magid join coy_testbed_tracking a on a.sender_email=k.child_email_id where s.pid=$pid_draft and m.p3_status=$resValue->p3_status  and s.cid=$resValue->cid and k.old_new=0 and  ( (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or 
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent<30) or 

// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam =0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=50) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam<=10 and total_new_spam <= 2 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=45) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>0 and actual_sent<30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>=30 and mail_open>=40) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent=0 and mail_open=0) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=120 and total_replied <150 and actual_sent>30 and mail_open>=35) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=30) or
// (testbed_sent is not null and testbed_sent !=0  and  testbed_sent!='NULL' and total_spam=0 and total_new_spam = 0 and total_replied >=150 and total_replied <200 and actual_sent>30 and mail_open>=25) ) and coy_cxo_flag =0 and k.child_email_id='$this->sender_email' group by k.child_email_id order by mail_open desc limit 1")->get();
                              if(count($assign_child_id) == 0){
                                echo ">>> Email ID not ready to send kajol > ".$mail_type;
                                $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                if(count($select_stuck)==0){
                                  $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Email ID not ready to send.','$mail_type',now(),now(),3)");
                                }
                                continue;
                              }else{
                                $this->magid = $assign_child_id[0]->magid;
                              }
                            } else {
                              $update_add = QB::query("update addperson_detail set first_senddate='',rem_senddate='',cws_senddate='',total_email_sent='' where cid=$resValue->cid and email_id='$recevemail'");
                              echo ">>> Sender Email Not Assigned";
                              continue;
                            }
                          }
                        }

                        if($resValue->extra_field2 == '1'){
                          $magazine_blocked = QB::query("select magid from magazine_details where magid =$this->magid and hold_ot=1 ")->get();
                          if(count($magazine_blocked) > 0){
                            echo "\n Magazine Blocked OT";
                            $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                          if(count($select_stuck)==0){
                              $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Magazine Blocked OT.','$mail_type',now(),now(),3)");
                          }
                            continue;
                          }
                        }else{
                          $magazine_blocked = QB::query("select magid from magazine_details where magid =$this->magid and hold_non_ot=1 ")->get();
                          if(count($magazine_blocked) > 0){
                            echo "\n Magazine Blocked Non OT";
                            $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                          if(count($select_stuck)==0){
                              $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Magazine Blocked Non OT.','$mail_type',now(),now(),3)");
                          }
                            continue;
                          }
                        }






                        if ($this->sender_email == '' || $this->sender_email == null || $this->sender_email == 'NULL') {
                          echo "Sender Email Not Assigned";
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Sender Email Not Assigned.','$mail_type',now(),now(),3)");
}
                          continue;
                        }


                        
                          // echo "\n" .   $schedule_time="12:30:00";
                          echo "\n" .  $this->timestampnew;
                          $get_magid = QB::query("select magid,(select magazine_name from magazine_details where magid=k.magid) magname from special_company_magid k where pid=$pid_draft and category in(select p3_status from master_companies where cid= $resValue->cid) and cid=$resValue->cid")->get();
                          if(count($get_magid) == 0){

                if((strpos($this->sender_email, "canada") !== false)) {
                  $magid_like =" and magazine_name like '%canada%'";
                  } else if((strpos($this->sender_email, "latinamerica") !== false) || (strpos($this->sender_email, "latam") !== false)) {
                    $magid_like =" and (magazine_name like '%latam%' or magazine_name like '%latinamerica%')";
                }  else if((strpos($this->sender_email, "europe") !== false) || (strpos($this->sender_email, "mena") !== false) || (strpos($this->sender_email, "uk") !== false)) {
                  $magid_like =" and (magazine_name like '%europe%' or magazine_name like '%uk%' or magazine_name like '%mena%')";
              }
                 else if((strpos($this->sender_email, "apac") !== false)) {
                  $magid_like =" and magazine_name like '%apac%'";
                } 
                else{
                  $magid_like ='';
                }

                  $get_magid = QB::query("select k.magid, m.magazine_name as magname from special_project_details k join magazine_details m on m.magid=k.magid where pid=$pid_draft and category in(select p3_status from master_companies where cid= $resValue->cid) $magid_like")->get();
                  if(count($get_magid) == 0){
                    $get_magid = QB::query("select k.magid, m.magazine_name as magname from special_project_details k join magazine_details m on m.magid=k.magid where pid=$pid_draft and category in(select p3_status from master_companies where cid= $resValue->cid)  order by id desc limit 1")->get();
                  }
              }
                          if (count($get_magid) > 0) {
                            $m_id = $get_magid[0]->magid;
                            $magname = $get_magid[0]->magname;
                            
                            
                            if((strpos($magname, "Canada") !== false) || (strpos($magname, "CANADA") !== false)) {
                                
                                $schedule_time ='12:30:00';
                            } else if((strpos($magname, "Latin America") !== false) || (strpos($magname, "LATIN AMERICA") !== false)) {
                              
                                $schedule_time ='12:30:00';
                          } else if((strpos($magname, "Europe") !== false) || (strpos($magname, "EUROPE") !== false) || (strpos($magname, "Mena") !== false) || (strpos($magname, "MENA") !== false) || (strpos($magname, "UK") !== false) || (strpos($magname, "UK") !== false)) {
                            $schedule_time ='08:30:00';
                            } else if((strpos($magname, "Apac") !== false) || (strpos($magname, "APAC") !== false)) {
                              $schedule_time ='00:30:00';
                            } else if((strpos($magname, "MENA") !== false) || (strpos($magname, "MENA") !== false)) {
                              $schedule_time ='08:30:00';
                            } else{
                                $schedule_time ='12:30:00';
                          }
                        }
                          $firstTime = strtotime($schedule_time);
                          $lastTime = strtotime($this->timestampnew);
                          $t = $lastTime - $firstTime;
                          $K = $t / 60;
                          $K = round($K);
                          echo "\ntime_count:  " . $K;

                          if ($K >= 0 &&  $K <= 350) {
                          } else {
                           echo "\n" .   $send_flag = 1;

                          }



                        
                        
                        $this->sender_name = $this->profile_id = "";
                        $sender_email_domain_arr = explode('@', $this->sender_email);
                        $this->sender_email_domain = $sender_email_domain_arr[1];

                        

                        $outlook_draft = QB::query("select * from master_companies where  cid=$resValue->cid and extra_field2=1")->get();
                        if(count($outlook_draft) == 0){
                          $check_domain = QB::query("SELECT id FROM upload_magazines_subdomains u WHERE u.domain_hold=1 and u.magazine_subdomain='$this->sender_email_domain'")->get();
                          if(count($check_domain)>0){
                            $send_flag = 1;
                            $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            if(count($select_stuck)==0){
                                $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Domain Hold Non-OT','$mail_type',now(),now(),3)");
                            }
                          }
                        }else{
                          $check_domain = QB::query("SELECT id FROM upload_magazines_subdomains u WHERE u.domain_hold_ot=1 and u.magazine_subdomain='$this->sender_email_domain'")->get();
                          if(count($check_domain)>0){
                            $send_flag = 1;
                            $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            if(count($select_stuck)==0){
                                $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Domain Hold OT','$mail_type',now(),now(),3)");
                            }
                          }
                        }


                        // new code by kajol
                        $select_d3 = QB::query("select count(sno) d3_cnt from d3_info where email_id='$recevemail' and cid=$resValue->cid and pid=$pid_draft and leadstatus in(3,2) limit 1 ")->get();
                        $select_d3_cnt = $select_d3[0]->d3_cnt;
                        if ($select_d3_cnt > 0) {
                          $send_flag = 1;
                          echo "\n" . "2=======================>";
                          $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            if(count($select_stuck)==0){
                                $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Unsubscribe person','$mail_type',now(),now(),3)");
                            }
                        }

                        unset($sender_email_domain_arr);
                        




                        
                        //end

                        // APAC & EUROPE blocked

                        // echo "\n" . "select  count(pid) apac_cnt from projectinfo where  pid=$pid_draft and (magid in(51,52,53) or region_status in (2,3))";
                        // $check_apac_europe = QB::query("select  count(pid) apac_cnt from projectinfo where  pid=$pid_draft and (magid in(51,52,53) or region_status in (2,3))")->get();
                        // $check_apac_europe_cnt = $check_apac_europe[0]->apac_cnt;
                        // if ($check_apac_europe_cnt  > 0) {
                        //   //$send_flag = 1; //For checking apac europe condition 

                        // }
                        // end 

                        $check_fasttrack = QB::query("select id from emailprocess.exclude_email_gap_project where pid=$pid_draft limit 1")->get();
                        if (count($check_fasttrack) == 0) {
                          $check_closed = QB::query("select pid from projectinfo where pid=$pid_draft and status = 0 and print_online_hold_status = 0 limit 1")->get();
                          if (count($check_closed) == 0) {
                            $query_cmp = QB::query("select count(id) cmp_cnt from d3_compose where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                            $mailsendforcmp = $query_cmp[0]->cmp_cnt;
                            if ($mailsendforcmp > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Mail Already Sent/drafted today for this company.','$mail_type',now(),now(),3)");
}
                              $send_flag = 1;
                            }
                          }
                        }

                        //----------------------------New Condition 2021-06-28
                        $year_kk = date("Y");
                      $previousyear = $year_kk - 1;
                      $checktwotimesunsubscribe = QB::query("select  email_id from master_companies m   join d3_info d on m.pid = d.pid and m.cid = d.cid where m.lead_status = 3 and m.status > 0 and year(dateadded) >= $previousyear and email_id = '$recevemail'")->get();
                       if (count($checktwotimesunsubscribe)  >= 2) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Already in lead=3.','$mail_type',now(),now(),3)");
}
                          $send_flag = 1; //For checking unsubscribe 

                        }

                        

                        
                        

                        $query_chk_exist = QB::query("select count(*) chk_cnt from d3_session s join d3_compose c on s.session_id=c.session_id where s.addeddate between '$today 00:00:00' and '$today 23:59:59' and c.receiver_email='$recevemail' and c.pid=$pid_draft")->get();
                        $mailsendforcmp1 = $query_chk_exist[0]->chk_cnt;
if ($mailsendforcmp1 > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','already sent for today and has entry in session table.','$mail_type',now(),now(),3)");
}
                          $send_flag = 1;
                        } else {
                          if ($this->mds_server_status == 1) {
                            $query_chk_leads = QB::query("select count(*) chk_cnt from master_companies m join addperson_detail a on m.cid=a.cid where (m.lead_status not in(0,3,2) or m.status>0) and m.cid=$resValue->cid and a.email_id='$recevemail' and m.pid=$pid_draft")->get();

                            $mailsendforcmp1 = $query_chk_leads[0]->chk_cnt;
                            if ($mailsendforcmp1 > 0) {
                              $leadstus = $query_chk_leads[0]->lead_status;
                              if ($leadstus == 2) {
                                $query_chk_leadss = QB::query("select count(*) chk_cnt1 from master_companies m join addperson_detail a on m.cid=a.cid join d3_info d on m.cid=d.cid and d.email_id=a.email_id where m.lead_status=2 and m.cid=$resValue->cid and a.email_id='$recevemail' and m.pid=$pid_draft")->get();
                                $mailsendforcmp11 = $query_chk_leadss[0]->chk_cnt1;
                                if ($mailsendforcmp11 > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','already in lead=2.','$mail_type',now(),now(),3)");
}
                                  $send_flag = 1;
                                }
                              } else {
                                $send_flag = 1;
                              }
                            } else {
                              $lastYear = date("Y-m-d", strtotime("-180 days"));
                              $query_chk_spam = QB::query("select count(id) spam_int from gmail_table_bounce where date(dateadded) >= '$lastYear' and (receiver_email='$recevemail' or x_failed_recipients='$recevemail') and bounce_type='spam' and date(dateadded) > '2020-03-01'")->get();
                              $mailspam = $query_chk_spam[0]->spam_int;
                              if ($mailspam > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Bounce in last 6month','$mail_type',now(),now(),3)");
}
                                $send_flag = 1;
                              }
                            }
                          }

                          
                        }


                        

                        /*new lead code*/
                        if ($this->mds_server_status == 1) {

                          $leadcon = QB::query("select  email_id from master_companies m   join d3_info d on m.pid = d.pid and m.cid = d.cid where m.cid=$resValue->cid and (m.lead_status  in (1,13,14,5) and m.status in (0,6,9,2,1))")->get();
                          if (count($leadcon) > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Marked LEad For this company','$mail_type',now(),now(),3)");
}
                            $send_flag = 1; //For checking unsubscribe 

                          }

                          

                        }
                        /*new lead code end*/


                        

                        //only Europe remove country 
                        if ($this->mds_server_status == 1) {
                          $europecountry = QB::query("select count(cid) ukarian_cnt from master_companies  where  cid=$resValue->cid and country in('Ukraine') ")->get();
                            $count_europe_cntry = $europecountry[0]->ukarian_cnt;
                            if ($count_europe_cntry > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Ukraine Country','$mail_type',now(),now(),3)");
}
                              $send_flag = 1;
                            }

                          

                        }

                        // end

                        



                        if ($this->special_normal_premium == 1) {

                          if($resValue->rank == 10 || $resValue->rank == 11 || $resValue->rank == 5){
                            $day30 = date('Y-m-d 00:00:00', strtotime('-30 days'));
                            //continue;

                            $check_closure = QB::query("select compayny_id,(select dateadded  from cwf.cwf_sold_company_track where closer_id=s.comp_sold_id and status_id=1115 limit 1) deliver_date from cwf.cwf_sold_companies s where company_url='$resValue->curl' and type=0 order by comp_sold_id desc limit 1")->get();
                            if(count($check_closure) > 0){
                                $delivered_date = $check_closure[0]->deliver_date;
                                if($delivered_date>=$day30 && $delivered_date !='' && $delivered_date !='0000-00-00 00:00:00'){
                                  $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                  if(count($select_stuck)==0){
                                      $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Delivarables sent with in 30 days','$mail_type',now(),now(),3)");
                                  }
                                    continue;
                                }
                            }

                          }
                          if ($mail_type == 'First Mail' && $resValue->person_type == 'P1') {
                            $send_flag = 1;
                          }

                          $get_f_content = QB::query("select  count(id) past_cnt  from past_closures_mailing where pid= $pid_draft  and cid=$resValue->cid and mail_type='First Mail' and approved_status=1 and sent_by!='' and sent_by is not null and trim(send_date)!='' and send_date is not null and send_date!='0000-00-00 00-00' limit 1")->get();
                          $get_past_cnt =  $get_f_content[0]->past_cnt;
                          if ($get_past_cnt == 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','P1 First Mail Not Sent','$mail_type',now(),now(),3)");
}
                            $send_flag = 1;
                          }

                          

                          $get_d3_content = QB::query("select  count(id) d3_cnt  from d3_compose where addeddate between '$today 00:00:00' and '$today 23:59:59' and pid= $pid_draft  and company_type_status='$cmp_type' and cid=$resValue->cid  ")->get();
                          $get_d3_content_cnt = $get_d3_content[0]->d3_cnt;
                   if ($get_d3_content_cnt > 0) {
                            $send_flag = 1;
                          }
                        }

                        

                        $lead_domain = QB::query("select count(*) lead_cnt from projectinfo p join master_companies m on m.pid=p.pid where p.year>=$yearkk and curl='$resValue->curl' and lead_status in(1,5)   and p.pid not in (12421,12420,12418,12419)  and m.status not in (3,4,7,8,11,12,15,17)  and p.status in (0,1,3) and p.print_online_hold_status in (0,4,1,2) and p.project_status in (1,0)")->get();
                        $lead_domain_cnt = $lead_domain[0]->lead_cnt;
                        if ($lead_domain_cnt > 0) {
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Marked LEad For this company','$mail_type',now(),now(),3)");
}
                          $send_flag = 1;
                        }


                         $check_block_email = QB::query("select id from special_child_details where child_email_id ='$this->sender_email' and flag=0 and magid = $m_id")->get();
        if(count($check_block_email)>0){
            $send_flag = 1;
          echo "\n kajol>>> "."Email Id is Blocked";
$select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Email id blocked - $this->sender_email','$mail_type',now(),now(),3)");
}
        }

        echo "\n >>>>>>>>>>>>>>. ".$send_flag;
                        if ($send_flag == 0) {
                          $resValue->cname = addslashes($resValue->cname);
                          $resValue->cname = preg_replace("/[^ \w]+/", "", $resValue->cname);
                          $company_name2 = explode('@', $recevemail);
                          $company_url = $company_name2[1];
                          $company_url = trim($company_url, '/');
                          if (!preg_match('#^http(s)?://#', $company_url)) {
                            $company_url = 'http://' . $company_url;
                          }
                          $urlParts = parse_url($company_url);
                          $company_url_2 = preg_replace('/^www\./', '', $urlParts['host']);
                          $batchh = self::getBatch($resValue->cid);
                          if ($this->mds_server_status == 1) {
                            if (($batchh == 'BClient') || (($resValue->exception == 2) && ($resValue->bulk != 2000 && $resValue->bulk != 5000))) {
                              $html_content = self::Create_Old_Content($resValue->curl, $pid_draft, $current_mag_id, $resValue->cid);
                            }
                          } else {
                            if ($batchh == 'BClient') {
                              $html_content = self::Create_Old_Content($resValue->curl, $pid_draft, $current_mag_id, $resValue->cid);
                            }
                          }
                          if ($this->mds_server_status == 2) {
                            $get_lname = QB::query("select lname_status from projectinfo where pid = $pid_draft ")->get();
                            $lname_status  = $get_lname[0]->lname_status;
                            if ($lname_status == 1) {
                              $resValue->f_name = $resValue->f_name . " " . $resValue->l_name;
                            }
                          }



                          $check_coy = QB::query("select premium_normal from master_companies where cid=$resValue->cid")->get();
                          $premium_condition = $check_coy[0]->premium_normal;
                          $premium_condition = 1;

                          if ($this->special_normal_premium == 1) {
                            if (trim($mail_type) == 'First Mail') {
                              
                                if($premium_condition == 1){
                                $result_pre = QB::query("select p.content_type from past_closures_mailing p join premium_proposal_preview_content k on k.id=p.content_type where p.pid=$pid_draft  and p.cid=$resValue->cid and p.mail_type='First Mail' and p.content_type !=0 and p.content_type !=''  and k.act_deact = 0 $outlook_condition  and k.reminder_id !='' and k.reminder_id!=0 and k.cws_id!='' and k.cws_id!=0 and FIND_IN_SET($m_id, k.magid) > 0 order by p.id desc limit 1")->get();
                                $ref_id = $result_pre[0]->content_type;
                                }else{
                                    $result_pre = QB::query("select p.id from past_closures_mailing p where p.pid=$pid_draft  and p.cid=$resValue->cid and p.mail_type='First Mail' order by p.id desc limit 1")->get();
                                    $ref_id = $result_pre[0]->id;
                                }

                              $check_content = QB::query("select count(*) cnt from  premium_proposal_preview_content where id='$ref_id'  and act_deact = 1")->get();
                              $deact_pro = $check_content[0]->cnt;
                              if($deact_pro > 0 || $ref_id == '' || count($result_pre) == 0){
                                
                                if($premium_condition == 1){
                                  $coy_cond = "  and coy_cover=1";
                                  $magid_condition = "and FIND_IN_SET($m_id, magid) > 0";
                                }else{
                                    $magid_condition = "";
                                  $coy_cond = "  and coy_cover=5";
                                }
                                if ((strpos($magname, "Europe") !== false) || strpos($magname, "EUROPE") !== false || (strpos($magname, "Apac") !== false) || (strpos($magname, "APAC") !== false) || (strpos($magname, "Canada") !== false) || (strpos($magname, "CANADA") !== false) || (strpos($magname, "Latin America") !== false) || (strpos($magname, "LATIN AMERICA") !== false)) {
                                  if($premium_condition == 1){
                                    $region_cond = " and region in (2,3) ";
                                  }else{
                                    $region_cond = " and region in (1,3) ";
                                  }
                                  $contenbt_type_val = " and content_type = 'Startups Outside US'  ";
                                  } else{
                                      $region_cond = " and region in (1,3) ";
                                      $contenbt_type_val = " and content_type = 'Startups U.S' ";
                                  }
          
                                  $project_wisecond = " and proj_flag=0";
                                  $check_contentpid = QB::query("select * from premium_proposal_preview_content where project_id=$pid_draft and proj_flag = 1")->get();
                                  if(count($check_contentpid)>0){
                                      $project_wisecond = " and proj_flag=1 and project_id=$pid_draft ";
                                  }else{
                                      $project_wisecond = " and proj_flag=0";
                                  }
                                  if($pid_draft == 16209){
                                    $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $contenbt_type_val  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond order by rand() limit 1 ")->get();
                                    $ref_id = $result_pre1[0]->id;
                                    $ready_to_send = $result_pre1[0]->ready_to_send;
                                  }else{
                                    $result_pre1 = QB::query("select id,0 as ready_to_send  from  premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond and content_type !='Startups U.S' $magid_condition order by rand() limit 1")->get();
                                    $ref_id = $result_pre1[0]->id;
                                    $ready_to_send = $result_pre1[0]->ready_to_send;
                                  }
                                  
                              }
                            } else {

                              $n_p_pid = $pid_draft;
                              // rank 5 and normal premium mailing code starting by kajol

                              $last_year = date("Y", strtotime("-1 year"));

                              $get_magid = QB::query("select magid,(select magazine_name from magazine_details where magid=k.magid) magname from special_company_magid k where pid=$pid_draft and category in(select p3_status from master_companies where cid= $resValue->cid) and cid=$resValue->cid")->get();
                              if(count($get_magid) == 0){
                                $get_magid = QB::query("select magid,(select magazine_name from magazine_details where magid=k.magid) magname from special_project_details k where pid=$pid_draft and category in(select p3_status from master_companies where cid= $resValue->cid) order by id desc limit 1")->get();
                              }
                              if (count($get_magid) > 0) {
                                $m_id = $get_magid[0]->magid;
                                $magname = $get_magid[0]->magname;
                                
                                if ((strpos($magname, "Europe") !== false) || strpos($magname, "EUROPE") !== false) {
                                    $new_projects =" project_id in(11593,0) and ";
                                    $n_p_pidkk = "11593";
                                  } elseif((strpos($magname, "Apac") !== false) || (strpos($magname, "APAC") !== false)) {
                                    $new_projects =" project_id in(11594,0) and ";
                                    $n_p_pidkk = "11594";
                                  } else{
                                    $new_projects =" project_id in(11592,0) and ";
                                    $n_p_pidkk = "11592";
                                  }
                              }
                              if($resValue->rank == 10 || $resValue->rank == 11){
                                $select_oldpid= QB::query("select (select pid from collection.client_details where client_id=mi.cid limit 1) as Proj from master_companies_info mi where master_id=$resValue->cid")->get();
                  
                                if(count($select_oldpid)>0){
                                    $get_oldpid=$select_oldpid[0]->Proj;
                                    $check_mag=QB::query("select magid,pname from projectinfo where pid=$get_oldpid")->get();
                                    $old_mag=$check_mag[0]->magid;
                                    $oldmagazine=self::get_magazine($old_mag);
                                }else{
                                    $fetch_old_pid = QB::query("select pid from master_companies where curl = '$resValue->curl' and status=1 order by cid desc")->get();
                                    if(count($fetch_old_pid)>0){                        
                                      $fetch_old = $fetch_old_pid[0]->pid;
                                      $check_mag=QB::query("select magid,pname from projectinfo where pid=$fetch_old")->get();
                                      $old_mag=$check_mag[0]->magid;
                                      $oldmagazine=self::get_magazine($old_mag);
                                    }
                                }
                            
                                if($oldmagazine != $magname){
                                  $content_type_profile_val= " and status_name = 'SP Rank 10 Different Magazines'";      
                                }else{
                                  $content_type_profile_val= " and status_name = 'SP Rank5/10 Same Magazine'";
                                }
                                
                                  $get_status = QB::query("select status from emailprocess.companytype_status where project_id=$n_p_pidkk $content_type_profile_val")->get();
                                  if(count($get_status)>0){
                                    $category = $get_status[0]->status;
                                    $n_p_pid = $n_p_pidkk;
                                  }
                              }else{
                                $category = "3";
                              }

                              $select_qry_us = QB::query("select p.pid,p.old_pid,m.rank from projectinfo p join master_companies m on p.pid=m.pid where p.pid=$pid_draft and m.cid = $resValue->cid and `rank` in (10,11)")->get();
                              if (count($select_qry_us) > 0) {
                                $rank_val = $select_qry_us[0]->rank;
                                $get_closure = QB::query("select cw.profile_type from master_companies m join cwf.cwf_sold_companies cw on m.cid=cw.compayny_id where m.curl='$resValue->curl' and profile_type in (1,6,7) order by cw.comp_sold_id desc limit 1")->get();
                                if (count($get_closure) > 0) {
                                  $proposal = $proposalType = "Premium";
                                  $closer_type = $get_closure[0]->profile_type;
                                  if ($closer_type == 1) {
                                    $get_category = QB::query("select status_name ,status  from emailprocess.companytype_status where $new_projects status_name='Rank 10 Cover'")->get();
                                    if (count($get_category) > 0) {
                                      $category = $get_category[0]->status;
                                    }
                                  } elseif ($closer_type == 7) {
                                    $get_category = QB::query("select status_name ,status  from emailprocess.companytype_status where $new_projects status_name='Rank 10 COY'")->get();
                                    if (count($get_category) > 0) {
                                      $category = $get_category[0]->status;
                                    }
                                  } elseif ($closer_type == 6) {
                                    $get_category = QB::query("select status_name ,status  from emailprocess.companytype_status where $new_projects status_name='Rank 10 Editor Choice'")->get();
                                    if (count($get_category) > 0) {
                                      $category = $get_category[0]->status;
                                    }
                                  } 
                                  $n_p_pid = $n_p_pidkk;
                                }else {
                                  $proposal = $proposalType = "Normal";
                                }
                              }
                              //end


                              $result_pre = QB::query("select t.id, t.ready_to_send from session_content t where t.pid=$n_p_pid and t.mail_type='$mail_type' and t.draft_name='$proposal' and t.company_type_status='$category' and swap_nonswap_flag=0 and t.status=0 and (subject!='' and subject is not null) order by updateddate desc limit 1")->get();

                              $ref_id = $result_pre[0]->id;
                              $ready_to_send = $result_pre[0]->ready_to_send;

                              $check_coy = QB::query("select premium_normal from master_companies where cid=$resValue->cid")->get();
                              $premium_condition = $check_coy[0]->premium_normal;
                          $premium_condition = 1;
                              $region_cond='';
                    $coy_cond='';
                    if ($resValue->rank != 10 && $resValue->rank != 11 && $resValue->rank != 5) {
                      if($premium_condition == 1){
                        $coy_cond = "  and coy_cover=1";
                      }else{
                        $coy_cond = "  and coy_cover=5";
                      }
                      if ((strpos($magname, "Europe") !== false) || strpos($magname, "EUROPE") !== false || (strpos($magname, "Apac") !== false) || (strpos($magname, "APAC") !== false) || (strpos($magname, "Canada") !== false) || (strpos($magname, "CANADA") !== false) || (strpos($magname, "Latin America") !== false) || (strpos($magname, "LATIN AMERICA") !== false)) {
                        if($premium_condition == 1){
                        $region_cond = " and region in (2,3) ";
                      }else{
                        $region_cond = " and region in (1,3) ";
                      }
                      } else{
                          $region_cond = " and region in (1,3) ";
                      }
                      $project_wisecond = " and proj_flag=0";
                      $check_contentpid = QB::query("select * from premium_proposal_preview_content where project_id=$pid_draft and proj_flag = 1")->get();
                      if(count($check_contentpid)>0){
                          $project_wisecond = " and proj_flag=1 and project_id=$pid_draft ";
                      }else{
                          $project_wisecond = " and proj_flag=0";
                      }
                      if(($mail_type == 'Reminder 1' || $mail_type == 'Can We Schedule') && $premium_condition == 1){
                        echo "\n >>>>>>>>>>>>>>>>> "."select content_type from past_closures_mailing where cid=$resValue->cid and pid=$pid_draft and receiver_email like '%$recevemail%' and content_type!='' and content_type is not null and content_type!=0";
                      $take_firstids = QB::query("select content_type from past_closures_mailing where cid=$resValue->cid and pid=$pid_draft and receiver_email like '%$recevemail%' and content_type!='' and content_type is not null and content_type!=0")->get();
                      if(count($take_firstids)>0){
                        $first_idss = $take_firstids[0]->content_type;
                        echo "\n &&&&& "."select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0";
                        $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0")->get();
                        if(count($take_remcwsids)>0){
                            $rem_idss = $take_remcwsids[0]->reminder_id;
                            $cws_idss = $take_remcwsids[0]->cws_id;
                        }else{
                            $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition and content_type in ('Special COY Reminder Type 2 US','Special COY CWS Type 3 US','Special COY Reminder Type 2 Outside US','Special COY CWS Type 3 Outside US')  order by rand() limit 1 ")->get();
                        }
                      }else{
                        echo "\n <<>><><>< "."select content_ref_id from d3_compose where cid=$resValue->cid and pid=$pid_draft and receiver_email ='$recevemail' and content_ref_id!='' and content_ref_id is not null and content_ref_id!=0 and mail_type='First Mail'";
                        $take_firstids = QB::query("select content_ref_id from d3_compose where cid=$resValue->cid and pid=$pid_draft and receiver_email ='$recevemail' and content_ref_id!='' and content_ref_id is not null and content_ref_id!=0 and mail_type='First Mail'")->get();
                        if(count($take_firstids)>0){
                          $first_idss = $take_firstids[0]->content_ref_id;
                          echo "\n >>>>> "."select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0";
                          $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0")->get();
                          if(count($take_remcwsids)>0){
                            $rem_idss = $take_remcwsids[0]->reminder_id;
                            $cws_idss = $take_remcwsids[0]->cws_id;
                          }else{
                            $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition and content_type in ('Special COY Reminder Type 2 US','Special COY CWS Type 3 US','Special COY Reminder Type 2 Outside US','Special COY CWS Type 3 Outside US')  order by rand() limit 1 ")->get();
                          }
                        }else{
                            continue;
                        }
                      }
                      if($mail_type == 'Reminder 1' && count($take_remcwsids)>0){
                        echo "\n *** "."select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition  and id=$rem_idss";
                        $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition  and id=$rem_idss")->get();
                      }else if ($mail_type == 'Can We Schedule' &&  count($take_remcwsids)>0){
                        echo "\n ^^^ "."select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition  and id=$cws_idss order by rand() limit 1 ";
                        $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition  and id=$cws_idss order by rand() limit 1 ")->get();
                      }else{
                        $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition and content_type in ('Special COY Reminder Type 2 US','Special COY CWS Type 3 US','Special COY Reminder Type 2 Outside US','Special COY CWS Type 3 Outside US')  order by rand() limit 1 ")->get();
                      }

                      if(count($result_pre1)==0){
                        $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type' $project_wisecond  and act_deact = 0 $outlook_condition and content_type in ('Special COY Reminder Type 2 US','Special COY CWS Type 3 US','Special COY Reminder Type 2 Outside US','Special COY CWS Type 3 Outside US')  order by rand() limit 1 ")->get();
                      }
                    }else{
                      $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond and mail_type='$mail_type'   and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond order by rand() limit 1 ")->get();
                    }
                      $ref_id = $result_pre1[0]->id;
                      $ready_to_send = $result_pre1[0]->ready_to_send;
                    }else{

                            $select_oldpid = QB::query("select (select pid from collection.client_details where client_id=mi.cid limit 1) as Proj from master_companies_info mi where master_id=$resValue->cid")->get();
                              if (count($select_oldpid) > 0) {
                                $get_oldpid = $select_oldpid[0]->Proj;
                                $check_mag = QB::query("select magid,pname from projectinfo where pid=$get_oldpid")->get();
                                $old_mag = $check_mag[0]->magid;
                                $oldkkmagazine = QB::query("select magazine_name from magazine_details where magid=$old_mag")->get();
                                $oldmagazine = $oldkkmagazine[0]->magazine_name;
                              } else {
                                  $fetch_old_pid = QB::query("select pid from master_companies where curl = '$resValue->curl' and status=1 order by cid desc")->get();
                                  if (count($fetch_old_pid) > 0) {
                                    $fetch_old = $fetch_old_pid[0]->pid;
                                    $check_mag = QB::query("select magid,pname from projectinfo where pid=$fetch_old")->get();
                                    $old_mag = $check_mag[0]->magid;
                                    $oldkkmagazine = QB::query("select magazine_name from magazine_details where magid=$old_mag")->get();
                                    $oldmagazine = $oldkkmagazine[0]->magazine_name;
                                  }
                                }

                                if ($oldmagazine != $magname) {
                                  $magazine_cond = " and magazine_type ='Different Magazine' ";
                                } else {
                                  $magazine_cond = " and magazine_type ='Same Magazine' ";
                                }
                                  if($premium_condition == 1){
                                    $coy_cond = " and coy_cover in (3,4)";
                                  }else{
                                    $coy_cond = " and coy_cover in (7,8)";
                                  }
                                  if ((strpos($magname, "Europe") !== false) || strpos($magname, "EUROPE") !== false || (strpos($magname, "Apac") !== false) || (strpos($magname, "APAC") !== false) || (strpos($magname, "Canada") !== false) || (strpos($magname, "CANADA") !== false) || (strpos($magname, "Latin America") !== false) || (strpos($magname, "LATIN AMERICA") !== false)) {
                                    if($premium_condition == 1){
                                      $region_cond = " and region in (2,3) ";
                                    }else{
                                      $region_cond = " and region in (1,3) ";
                                    }
                                  } else{
                                      $region_cond = " and region in (1,3) ";
                                  }
                                  $project_wisecond = " and proj_flag=0";
                                  $check_contentpid = QB::query("select * from premium_proposal_preview_content where project_id=$pid_draft and proj_flag = 1")->get();
                                  if(count($check_contentpid)>0){
                                      $project_wisecond = " and proj_flag=1 and project_id=$pid_draft ";
                                  }else{
                                      $project_wisecond = " and proj_flag=0";
                                  }
                                  if(($mail_type == 'Reminder 1' || $mail_type == 'Can We Schedule') && $premium_condition == 1){
                                    echo "\n >>> "."select content_type from past_closures_mailing where cid=$resValue->cid and pid=$pid_draft and receiver_email like '%$recevemail%' and content_type!='' and content_type is not null and content_type!=0";
                                  $take_firstids = QB::query("select content_type from past_closures_mailing where cid=$resValue->cid and pid=$pid_draft and receiver_email like '%$recevemail%' and content_type!='' and content_type is not null and content_type!=0")->get();
                                  if(count($take_firstids)>0){
                                    $first_idss = $take_firstids[0]->content_type;
                                    echo "\n >>> "."select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0";
                                    $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0")->get();
                                    if(count($take_remcwsids)>0){
                                        $rem_idss = $take_remcwsids[0]->reminder_id;
                                        $cws_idss = $take_remcwsids[0]->cws_id;
                                    }else{
                                      $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where  reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0 $coy_cond $region_cond and mail_type='First Mail' and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond  and FIND_IN_SET($m_id, magid) > 0")->get();
                                      if(count($take_remcwsids)>0){
                                          $rem_idss = $take_remcwsids[0]->reminder_id;
                                          $cws_idss = $take_remcwsids[0]->cws_id;
                                      }else{
                                        $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                        if(count($select_stuck)==0){
                                            $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Proposal Missing','$mail_type',now(),now(),3)");
                                        }
                                        continue;
                                      }
                                    }
                                    
                                  }else{
                                    echo "\n >>> "."select content_ref_id from d3_compose where cid=$resValue->cid and pid=$pid_draft and receiver_email ='$recevemail' and content_ref_id!='' and content_ref_id is not null and content_ref_id!=0";
                                    $take_firstids = QB::query("select content_ref_id from d3_compose where cid=$resValue->cid and pid=$pid_draft and receiver_email ='$recevemail' and content_ref_id!='' and content_ref_id is not null and content_ref_id!=0")->get();
                                    if(count($take_firstids)>0){
                                      $first_idss = $take_firstids[0]->content_ref_id;
                                      echo "\n >>> "."select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0";
                                      $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where id=$first_idss and reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0")->get();
                                      if(count($take_remcwsids)>0){
                                        $rem_idss = $take_remcwsids[0]->reminder_id;
                                        $cws_idss = $take_remcwsids[0]->cws_id;
                                    }else{
                                      $take_remcwsids = QB::query("select reminder_id,cws_id from premium_proposal_preview_content where  reminder_id!='' and reminder_id!=0 and cws_id!='' and cws_id!=0 $coy_cond $region_cond and mail_type='First Mail' and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond  and FIND_IN_SET($m_id, magid) > 0")->get();
                                      if(count($take_remcwsids)>0){
                                          $rem_idss = $take_remcwsids[0]->reminder_id;
                                          $cws_idss = $take_remcwsids[0]->cws_id;
                                      }else{
                                        $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                        if(count($select_stuck)==0){
                                            $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Proposal Missing','$mail_type',now(),now(),3)");
                                        }
                                        continue;
                                      }
                                    }
                                    }else{
                                        continue;
                                    }
                                  }
                                  if($mail_type == 'Reminder 1' && count($take_remcwsids)>0){
                                    $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond $magazine_cond and mail_type='$mail_type'  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond and id=$rem_idss order by rand() limit 1 ")->get();
                                    if(count($result_pre1) == 0){
                                      $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond $magazine_cond and mail_type='$mail_type'  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond and FIND_IN_SET($m_id, magid) > 0 order by rand() limit 1 ")->get();
                                    }
                                  }else if($mail_type == 'Can We Schedule' && count($take_remcwsids)>0){
                                    $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond $magazine_cond and mail_type='$mail_type'  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond and id=$cws_idss order by rand() limit 1 ")->get();
                                    if(count($result_pre1) == 0){
                                      $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond $magazine_cond and mail_type='$mail_type'  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond and FIND_IN_SET($m_id, magid) > 0 order by rand() limit 1 ")->get();
                                    }
                                  }else{
                                    $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
                                    if(count($select_stuck)==0){
                                        $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Proposal Missing for Rem and CWS','$mail_type',now(),now(),3)");
                                    }
                                    continue;
                                  }
                                }else{
                                  $result_pre1 = QB::query("select id,0 as ready_to_send from premium_proposal_preview_content where pid=2 $coy_cond $region_cond $magazine_cond and mail_type='$mail_type'  and act_deact = 0 $outlook_condition and proposal_status= 2 $project_wisecond  and FIND_IN_SET($m_id, magid) > 0 order by rand() limit 1")->get();
                                }

                                  
                                  $ref_id = $result_pre1[0]->id;
                                  $ready_to_send = $result_pre1[0]->ready_to_send;
                              }
                            }
                          } else {

                          }


                          $resValue->designation = addslashes($resValue->designation);
                          $check_nonswap = QB::query("select email from sender_email where pid = $pid_draft and email = '$this->sender_email' and swap_status = 1 limit 1")->get();
                          // new code written by kajol
                          $apac_condition = QB::query("select * from projectinfo where (magid in(51,52) or region_status in(2))  and pid=$pid_draft ")->get();

                          // $today_date = date('Y-m-d H:s');
                          $today_date = date("Y-m-d H:i:s");
                          $add_date = date("Y-m-d H:i:s", strtotime($today_date . " +5 hour +30 minutes"));
                          $today1 = date("Y-m-d");

                          if (count($apac_condition) > 0) { //apac  

                            $date_var = $add_date;
                            // date_default_timezone_set('Asia/Kolkata');   
                            $today_date = date("Y-m-d H:i:s");
                            $today1 = date("Y-m-d");
                          } else { //us & europe
                            $date_var = $today_date;
                          }




                          // new code end

                          try {
                            if ($drafting_type == 2) {

                              if (count($check_nonswap) == 0) {
                                //New temporary Insert Mailing code

                                $check_email = QB::query("select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ")->get();
                                if (count($check_email) > 0) {
                                  $email_flag = $check_email[0]->email_flag;
                                  if ($email_flag == 0) {


                                    $update_track = QB::query("update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                  } else {

                                    $update_track = QB::query("update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                  }
                                } else {

                                  $insert_track = QB::query("insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')");
                                }
                                // New code end
                              if($ref_id !='' && $ref_id !=''){

                                $check_data = QB::query("select id from d3_compose where pid=$pid_draft  and receiver_email ='$recevemail' and mail_type ='$mailTypeStatus'")->get();
                                if(count($check_data)==0){
                                $sql_comp = "insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values(:session_id,:receiver_email,:receiver_name,:company,:designation,:curl,:pid,:send_status,:cid,:field7,:content_ref_id,:sender_email,:mail_type,:company_type_status,:addeddate)";
                                $conn = QB::pdo();
                                $query_comp = $conn->prepare($sql_comp);
                                $query_comp->execute(array(':session_id' => $session_id, ':receiver_email' => $recevemail, ':receiver_name' => $resValue->f_name, ':company' => $resValue->cname, ':designation' => $resValue->designation, ':curl' => $resValue->curl, ':pid' => $pid_draft, ':send_status' => 0, ':cid' => $resValue->cid, ':field7' => $html_content, ':content_ref_id' => $ref_id, ':sender_email' => $this->sender_email, ':mail_type' => $mailTypeStatus, ':company_type_status' => $mailingProcess, ':addeddate' => $date_var));
                                $updateadd_per = QB::query("update addperson_detail set child_email_id='$this->sender_email' where cid=$resValue->cid and email_id='$recevemail'");
                                }
                              }
                              }
                            } else {
                              //New temporary Insert Mailing code

                              $check_email = QB::query("select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ")->get();
                              if (count($check_email) > 0) {
                                $email_flag = $check_email[0]->email_flag;
                                if ($email_flag == 0) {

                                  $update_track = QB::query("update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                } else {

                                  $update_track = QB::query("update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                }
                              } else {

                                $insert_track = QB::query("insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')");
                              }

                              if($ref_id !='' && $ref_id !=''){
                                $check_data = QB::query("select id from d3_compose where pid=$pid_draft  and receiver_email ='$recevemail' and mail_type ='$mailTypeStatus'")->get();
                              if(count($check_data)==0){
                              // New code end
                              $check_data = QB::query("select id from d3_compose where pid=$pid_draft  and receiver_email ='$recevemail' and mail_type ='$mailTypeStatus'")->get();
                              if(count($check_data)==0){
                                echo "\n 5555555555555555555555 "."insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values('$session_id','$recevemail','$resValue->f_name','$resValue->cname','$resValue->designation','$resValue->curl','$pid_draft',0,$resValue->cid,'$html_content','$ref_id','$this->sender_email','$mailTypeStatus','$mailingProcess','$date_var')";
                                $sql_comp = QB::query("insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values('$session_id','$recevemail','$resValue->f_name','$resValue->cname','$resValue->designation','$resValue->curl','$pid_draft',0,$resValue->cid,'$html_content','$ref_id','$this->sender_email','$mailTypeStatus','$mailingProcess','$date_var')");

                              // New code end
                              // $sql_comp = "insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values(:session_id,:receiver_email,:receiver_name,:company,:designation,:curl,:pid,:send_status,:cid,:field7,:content_ref_id,:sender_email,:mail_type,:company_type_status,:addeddate)";
                              // $conn = QB::pdo();
                              // $query_comp = $conn->prepare($sql_comp);
                              // $query_comp->execute(array(':session_id' => $session_id, ':receiver_email' => $recevemail, ':receiver_name' => $resValue->f_name, ':company' => $resValue->cname, ':designation' => $resValue->designation, ':curl' => $resValue->curl, ':pid' => $pid_draft, ':send_status' => 0, ':cid' => $resValue->cid, ':field7' => $html_content, ':content_ref_id' => $ref_id, ':sender_email' => $this->sender_email, ':mail_type' => $mailTypeStatus, ':company_type_status' => $mailingProcess, ':addeddate' => $date_var));
                                $updateadd_per = QB::query("update addperson_detail set child_email_id='$this->sender_email' where cid=$resValue->cid and email_id='$recevemail'");
                              }else{
                                $select_stuck = QB::query("select id from premium_drafting_stuck where addeddate between '$today 00:00:00' and '$today 23:59:59' and cid=$resValue->cid")->get();
if(count($select_stuck)==0){
    $insert_stuck = QB::query("insert into premium_drafting_stuck (cid,pid,receiver_email,reason,mail_type,addeddate,updtaedate,flag) values($resValue->cid,$pid_draft,'$recevemail','Mail Already draft/sent  today for this project.','$mail_type',now(),now(),3)");
}
                              }
                              }
                            }
                            }
                          } catch (Exception $e) {

                            $e->getMessage();

                            $substring = "Duplicate entry";
                            if (strpos($e, $substring) !== false) {
                              //if($this->mds_server_status == 2){
                              $del_old_data1 = QB::query("delete from d3_compose where mail_type='$mailTypeStatus' and pid=$pid_draft and receiver_email='$recevemail' and date(addeddate)!='$today'");
                              //}
                              if ($this->mds_server_status == 1) {
                                $insert_bcp_cm = QB::query("insert into compose_del_data (id,session_id,receiver_email,receiver_name,company,curl,designation,field5,field6,field7,send_status,send_date,bounce_status,bounce_date,sender_name,sender_email,mail_type,pid,status,cid,gmail_sent_status,gmail_send_date,addeddate,content_ref_id) select id,session_id,receiver_email,receiver_name,company,curl,designation,field5,'compose old data' as field6,field7,send_status,send_date,bounce_status,bounce_date,sender_name,sender_email,mail_type,pid,status,cid,gmail_sent_status,gmail_send_date,addeddate,content_ref_id from d3_compose where mail_type='$mailTypeStatus' and pid=$pid_draft and receiver_email='$recevemail' and date(addeddate)!='$today'");
                              }
                              $del_old_data2 = QB::query("delete from d3_compose where mail_type='$mailTypeStatus' and pid=$pid_draft and receiver_email='$recevemail' and (addeddate is null or trim(addeddate)='')");


                              $sel_old_data = QB::query("select * from d3_compose where mail_type='$mailTypeStatus' and pid=$pid_draft and receiver_email='$recevemail' and addeddate between '$today 00:00:00' and '$today 23:59:59'")->get();


                              if (count($sel_old_data) == 0) {
                                if ($drafting_type == 2) {

                                  if (count($check_nonswap) == 0) {

                                    //New temporary Insert Mailing code
                                    echo "---------------select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ===";
                                    $check_email = QB::query("select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ")->get();
                                    if (count($check_email) > 0) {
                                      $email_flag = $check_email[0]->email_flag;
                                      if ($email_flag == 0) {
                                        echo "update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'";
                                        $update_track = QB::query("update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                      } else {
                                        echo "update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'";
                                        $update_track = QB::query("update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                      }
                                    } else {
                                      echo "insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')";
                                      $insert_track = QB::query("insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')");
                                    }
                                    // New code end
                                    if($ref_id !='' && $ref_id !=''){

                                      $check_data = QB::query("select id from d3_compose where pid=$pid_draft  and receiver_email ='$recevemail' and mail_type ='$mailTypeStatus'")->get();
                                      if(count($check_data)==0){
                                    $sql_comp1 = "insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values(:session_id,:receiver_email,:receiver_name,:company,:designation,:curl,:pid,:send_status,:cid,:field7,:content_ref_id,:sender_email,:mail_type,:company_type_status,:addeddate)";
                                    $conn = QB::pdo();
                                    $query_comp1 = $conn->prepare($sql_comp1);

                                    $query_comp1->execute(array(':session_id' => $session_id, ':receiver_email' => $recevemail, ':receiver_name' => $resValue->f_name, ':company' => $resValue->cname, ':designation' => $resValue->designation, ':curl' => $resValue->curl, ':pid' => $pid_draft, ':send_status' => 0, ':cid' => $resValue->cid, ':field7' => $html_content, ':content_ref_id' => $ref_id, ':sender_email' => $this->sender_email, ':mail_type' => $mailTypeStatus, ':company_type_status' => $mailingProcess, ':addeddate' => $date_var));
                                    $updateadd_per = QB::query("update addperson_detail set child_email_id='$this->sender_email' where cid=$resValue->cid and email_id='$recevemail'");
                              }
                            }
                                  }
                                } else {

                                  //New temporary Insert Mailing code
                                  echo "---------------select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ===";
                                  $check_email = QB::query("select email_id,email_flag from temporary_email_tracking where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'  ")->get();
                                  if (count($check_email) > 0) {
                                    $email_flag = $check_email[0]->email_flag;
                                    if ($email_flag == 0) {
                                      echo "update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'";
                                      $update_track = QB::query("update temporary_email_tracking set email_flag = 1,pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                    } else {
                                      echo "update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'";
                                      $update_track = QB::query("update temporary_email_tracking set pid = $pid_draft,cid = '$resValue->cid' where  email_id = '$recevemail' and addeddate between '$today1 00:00:00' and '$today1 23:59:59'");
                                    }
                                  } else {
                                    echo "insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')";
                                    $insert_track = QB::query("insert into temporary_email_tracking(pid,cid,email_id,addeddate,email_flag) value ('$pid_draft','$resValue->cid','$recevemail','$today_date','2')");
                                  }
                                  if($ref_id !='' && $ref_id !=''){

                                    $check_data = QB::query("select id from d3_compose where pid=$pid_draft  and receiver_email ='$recevemail' and mail_type ='$mailTypeStatus'")->get();
                                    if(count($check_data)==0){
                                  // New code end
                                  $sql_comp1 = "insert into d3_compose(session_id,receiver_email,receiver_name,company,designation,curl,pid,send_status,cid,field7,content_ref_id,sender_email,mail_type,company_type_status,addeddate) values(:session_id,:receiver_email,:receiver_name,:company,:designation,:curl,:pid,:send_status,:cid,:field7,:content_ref_id,:sender_email,:mail_type,:company_type_status,:addeddate)";
                                  $conn = QB::pdo();
                                  $query_comp1 = $conn->prepare($sql_comp1);

                                  $query_comp1->execute(array(':session_id' => $session_id, ':receiver_email' => $recevemail, ':receiver_name' => $resValue->f_name, ':company' => $resValue->cname, ':designation' => $resValue->designation, ':curl' => $resValue->curl, ':pid' => $pid_draft, ':send_status' => 0, ':cid' => $resValue->cid, ':field7' => $html_content, ':content_ref_id' => $ref_id, ':sender_email' => $this->sender_email, ':mail_type' => $mailTypeStatus, ':company_type_status' => $mailingProcess, ':addeddate' => $date_var));
                                    $updateadd_per = QB::query("update addperson_detail set child_email_id='$this->sender_email' where cid=$resValue->cid and email_id='$recevemail'");
                                }
                              }
                            }
                              }
                            }
                          }

                          $incrCount++;

                          unset($html_content);
                        }

                        unset($result_pro1);

                        // echo $incrCount."---------->inserted";
                      }

                      if ($incrCount > 0) {

                        //echo '<li>second--->'."insert into session(session_id,count_sheet_email, uid, pid, flag, addeddate,mail_type,draft_name,company_type_status,person_assignd_id,session_type,content_ref_id,yet_to_send,ttl_drafted) values('$session_id','$resValue->ttl_data',$this->u_id,$pid_draft,0,NOW(),'$mailTypeStatus','$proposalType',$mailingProcess,$this->u_id,1,$ref_id,$ready_to_send,$incrCount)";
                        

                        if($ready_to_send == ''){
                          $ready_to_send = 0;
                        }
                        if($ref_id == ''){
                          $ref_id = 0;
                      }

                      $check_d3 = QB::query("select count(*) cnt from d3_session where mail_type ='$mailTypeStatus' and addeddate= NOW() and pid = $pid_draft and company_type_status ='$mailingProcess' and draft_name='$proposalType' ")->get();
                      $d3_counts = $check_d3[0]->cnt;
                      if($d3_counts == 0){
                        echo "\n"."insert into d3_session(session_id, count_sheet_email, uid, pid, flag, addeddate, mail_type,draft_name,company_type_status,person_assignd_id,session_type,content_ref_id,yet_to_send,ttl_drafted) values('$session_id','$ttl_data',$this->u_id,$pid_draft,0,NOW(),'$mailTypeStatus','$proposalType',$mailingProcess,$this->u_id,1,$ref_id, $ready_to_send,$incrCount)";
                        if($ref_id == ''){
                          $ref_id = 0;
                        }
                        $check_query = QB::query("select * from d3_session where mail_type ='$mailTypeStatus' and addeddate =NOW() and pid =$pid_draft and company_type_status='$mailingProcess' and draft_name ='$proposalType'")->get();
                        if(count($check_query)==0){
                          $sql_sess = "insert into d3_session(session_id, count_sheet_email, uid, pid, flag, addeddate, mail_type,draft_name,company_type_status,person_assignd_id,session_type,content_ref_id,yet_to_send,ttl_drafted) values(:session_id,:count_sheet_email,:uid,:pid,:flag,NOW(),:mail_type,:draft_name,:company_type_status,:person_assignd_id,:session_type,:content_ref_id,:yet_to_send,:ttl_drafted)";
                          $conn = QB::pdo();
                          $query_sess = $conn->prepare($sql_sess);
                          $query_sess->execute(array(':session_id' => $session_id, ':count_sheet_email' => $ttl_data, ':uid' => $this->u_id, ':pid' => $pid_draft, ':flag' => 0,  ':mail_type' => $mailTypeStatus, ':draft_name' => $proposalType, ':company_type_status' => $mailingProcess, ':person_assignd_id' => $this->u_id, ':session_type' => 1, ':content_ref_id' => $ref_id, ':yet_to_send' => $ready_to_send, ':ttl_drafted' => $incrCount));
                        }
                      }
                        
                      }
                    } else {
                    }
                  }
                }
              }
            }
          }
        }
        echo 1;
        // exit;

        /*proposal end */
      }
    }


    exit;
  }



  public function getSession()
  {
    $length = 20;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $stringa = "";
    for ($p = 0; $p < $length; $p++) {
      $stringa .= $characters[mt_rand(0, strlen($characters))];
    }
    return $stringa;
  }

  public function get_count_of_cover($pidno, $status)
  {
    $query = QB::query("select count(*) as cover_status from collection.client_details a join master_companies m on a.cid=m.cid where a.pid=$pidno and a.profile_type='Cover' and m.p3_status=$status")->get();
    return $query[0]->cover_status;
  }
}
$company_obj = new Add_company();
