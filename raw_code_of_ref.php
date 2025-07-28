 <?php

public function draftEmailGmailAPI_prahar($receiver_email_id, $receiver_name, $company_name, $designation_email_f, $project_sel_f, $magid, $compny_id, $mail_type, $sender_email, $subject_f, $mail_content, $unique_id, $add_person_id, $client_g, $field5, $field6, $field7, $cmp_status, $draft_name, $sender_domain, $lname = null, $signature = null, $signature_swap = null, $seg_type, $session_id)
  {
    $getpname="{{newprojectwithyear}}";
    $getmname="{{newmagazine}}";
    $getpname2="{{newproject}}";
    $getpname1 = '';
    $blockmail = 0;
    $getspecial = QB::query("select special from projectinfo where pid=$project_sel_f")->get();
    $special_kaj = $getspecial[0]->special;
    if ($project_sel_f != null && $project_sel_f != '') {
      echo "\n select region_status,region_status2,pname,pid,magid,year,(select magazine_name from magazine_details where magid=p.magid) mname,status,print_online_hold_status from projectinfo p where pid=$project_sel_f ";
      $getpmname = QB::query("select region_status,region_status2,pname,pid,magid,year,(select magazine_name from magazine_details where magid=p.magid) mname,status,print_online_hold_status from projectinfo p where pid=$project_sel_f ")->get();
      $getyear = $getpmname[0]->year;
      $getpname = $getpmname[0]->pname;
      $getpname1 = explode($getyear, $getpname);
      $getpname2 = $getpname1[0];
      $getmname = $getpmname[0]->mname;
      $add_magid = $getpmname[0]->magid;
      $project_closed_status = $getpmname[0]->status;
      $project_region_status2 = $getpmname[0]->region_status2;
      $project_region_status = $getpmname[0]->region_status;
      $project_print_online_hold_status = $getpmname[0]->print_online_hold_status;
    }

    $magid_kk = $add_magid;
    if ($magid_kk != '' && $magid_kk != 'NULL' && $magid_kk != 0) {
      $get_subdomain = QB::query("select count(*) cnt from upload_magazines_subdomains where magid = $magid_kk and magazine_subdomain='$sender_domain'")->get();
      $get_subdomain_cnt = $get_subdomain[0]->cnt;
      if ($get_subdomain_cnt == 0) {
        $blockmail = 1;
        $return_val = "email_domain_not_match_magazine";
        return $return_val;
      }
    } else {
      $blockmail = 1;
      $return_val = "email_domain_not_match_magazine";
      return $return_val;
    }
    $get_magurl = QB::query("select magazine_url,mag_description from magazine_details where magid = $add_magid")->get();

    $aboutMagazine = $get_magurl[0]->mag_description;
      $show_magurl = $get_magurl[0]->magazine_url;
      $mnameurl = "<a href='http://www." . $show_magurl . "' target='_blank'>" . $getmname . "</a>";
      $mnameurl_new = $getmname." ".$show_magurl;
      if ($aboutMagazine == '') {
        $aboutMagazine = "{{aboutMagazine}}";
      }

    if ($compny_id != '') {
      $select_oldpid = QB::query("select (select pid from collection.client_details where client_id=mi.cid limit 1) as Proj from master_companies_info mi where master_id=$compny_id")->get();

      if (count($select_oldpid) > 0) {
        $get_oldpid = $select_oldpid[0]->Proj;
        $check_mag = QB::query("select magid,pname from projectinfo where pid=$get_oldpid")->get();
        $old_mag = $check_mag[0]->magid;
        $oldproject = $check_mag[0]->pname;
        $oldmagazine = self::get_magazine($old_mag);

        $get_oldmagurl = QB::query("select magazine_url from magazine_details where magid = $old_mag")->get();
        $show_oldmagurl =$get_oldmagurl[0]->magazine_url;
        $oldmnameurl ="<a href='http://www.".$show_oldmagurl."' target='_blank'>".$oldmagazine."</a>";

      } else {
        $select_oldpid_agin = QB::query("select curl from master_companies where cid=$compny_id")->get();
        $curl =  $select_oldpid_agin[0]->curl;
        $fetch_old_pid = QB::query("select pid from master_companies where curl = '$curl' and status=1 order by cid desc")->get();
        if (count($fetch_old_pid) > 0) {
          $fetch_old = $fetch_old_pid[0]->pid;
          $check_mag = QB::query("select magid,pname from projectinfo where pid=$fetch_old")->get();
          $old_mag = $check_mag[0]->magid;
          $oldproject = $check_mag[0]->pname;
          $oldmagazine = self::get_magazine($old_mag);
          $get_oldmagurl = QB::query("select magazine_url from magazine_details where magid = $old_mag")->get();
          $show_oldmagurl =$get_oldmagurl[0]->magazine_url;
          $oldmnameurl ="<a href='http://www.".$show_oldmagurl."' target='_blank'>".$oldmagazine."</a>";
        }
      }
    } else {
      $oldproject = "{{oldproject}}";
      $oldmagazine = "{{oldmagazine}}";
      $oldmnameurl="{{oldmagazinewithlink}}";
    }

    if ($lname != null && $lname != '') {
      $lname = $lname;
    }


    $check_japan = QB::query("select country,p3_status,general_category,other_country,master_com_id from master_companies where cid = $compny_id limit 1")->get();
    $cntry = $check_japan[0]->country;
    $p3_status_kk = $check_japan[0]->p3_status;
        $general_category = $check_japan[0]->general_category;
    $other_country = $check_japan[0]->other_country;
    $master_com_id = $check_japan[0]->master_com_id;
        $get_generatcat = QB::query("select category_name from company_wise_general_categories where id =$general_category limit 1")->get();
        if(count($get_generatcat)>0){
          $general_cat_name = $get_generatcat[0]->category_name;
        }else{
          $general_cat_name='{{general_category}}';
        }
    if($cntry == 'Japan'){
      $lname .=' San';
    }
    //kajol
    // if($this->mds_server_status == 1){
      $show_ranking_name="{{ranking_name}}";
      $get_ranking_name = QB::query("select ranking_name from category_link_with_ranking where pid=$project_sel_f and category_status = $p3_status_kk order by id desc limit 1")->get();
      if(count($get_ranking_name)>0){
        $show_ranking_name = $get_ranking_name[0]->ranking_name;
      }else{
        $show_ranking_name = "{{ranking_name}}";
      }
    // }

     $check_emails = QB::query("select project_email from project_wise_sender_emails where pid= $project_sel_f ")->get();
      if(count($check_emails)>0){
        $sign_pid = $check_emails[0]->project_email;
      }else{
        $sign_pid = $project_sel_f;
      }

      echo "<li> KKKKKKKKKKKKKKKK " . "select signature,first_name,last_name,signature_flag,pid from sender_email where  magid= $magid and email = '$sender_email' and signature !='' and signature != 'NULL' and signature is not null order by id desc limit 1"; 
      $kk_signature = QB::query("select signature,first_name,last_name,signature_flag,pid from sender_email where magid= $magid and email = '$sender_email' and signature !='' and signature != 'NULL' and signature is not null  and activate =0 order by id desc limit 1")->get();
      if (count($kk_signature) == 0) {
        $kk_signature = QB::query("select signature,first_name,last_name,signature_flag,pid from sender_email where  magid= $magid and email = '$sender_email' and signature !='' and signature != 'NULL' and signature is not null order by id desc limit 1")->get();
      }
    if(count($kk_signature)>0){
      $first_name_kk = $kk_signature[0]->first_name;
      $last_name_kk = $kk_signature[0]->last_name;
      $signature_flagkk= $kk_signature[0]->signature_flag;
      $check_pid= $kk_signature[0]->pid;
      $check_cxo = QB::query("select special from projectinfo where pid=$check_pid and special in (2,4)")->get();
      if(count($check_cxo)>0){
        $blockmail = 1;
        $return_val = "cxoproject_signature";
        return $return_val;
      }
      $kk_signature = stripslashes(stripslashes(stripslashes($kk_signature[0]->signature)));
      if($kk_signature != null && $kk_signature !=''){
        $signature = $kk_signature;
        $domainsender=explode("@",$sender_email);
        $firstname =$domainsender[0];
        $firstname1=explode(".",$firstname);
        $signname =$firstname1[0];
        $lowersign=strtolower($signname);
        $lowersignature=strtolower($signature);
        if(strpos($lowersignature,$lowersign) !== false){                
          $signature_new = $signature;
        }
      }

    }else{

      $query_show=QB::query("select f_name, l_name from proposal_fname_details where pid=$project_sel_f")->get();
      if(count($query_show)>0){
        $first_name_kk=$query_show[0]->f_name;
        $last_name_kk=$query_show[0]->l_name;
      }

    if ($signature != null && $signature != '') {
      $signature = $signature;
      $domainsender = explode("@", $sender_email);
      $firstname = $domainsender[0];
      $firstname1 = explode(".", $firstname);
      if (count($firstname1) == 2) {
        $signname = substr($firstname1[0], 0, -1);
      } else {
        $signname = $firstname1[0];
      }
      $lowersign = strtolower($signname);
      $lowersignature = strtolower($signature);
      if (strpos($lowersignature, $lowersign) !== false) {
        $signature_new = $signature;
      }
    }


    if ($signature_swap != null && $signature_swap != '') {
      $signature_swap = $signature_swap;
      $domainsender = explode("@", $sender_email);
      $firstname = $domainsender[0];
      $firstname1 = explode(".", $firstname);
      if (count($firstname1) == 2) {
        $signname = substr($firstname1[0], 0, -1);
      } else {
        $signname = $firstname1[0];
      }
      $lowersign = strtolower($signname);
      $lowersignature_swap = strtolower($signature_swap);
      if (strpos($lowersignature_swap, $lowersign) !== false) {
        $signature_new = $signature_swap;
      }
    }

      }
    /*New code for Signature end*/
    $this->signval_new = 0;
    // $signature_flagkk == 0;
    // $check_new_sign = QB::query("select id from sender_email where pid=$project_sel_f and signature_flag =1 limit 1")->get();
    // if(count($check_new_sign)>0){
    //   $signature_flagkk == 1;
    // }else{
    //   $signature_flagkk == 0;
    // }
    $unsubs_flag = 0;
    $check_newunsub_line = strpos($mail_content, "{{unsub_OT}}");
    if ($check_newunsub_line !== false) {
      $unsubs_flag = 1;
    }
    if($special_kaj !=5 && $unsubs_flag == 1){
      $this->signval_new = 1;
      $phone_number_query = QB::query("select phone_number from project_wise_phone_number where pid = $project_sel_f")->get(); 
      if (count($phone_number_query) > 0) {
          $salesphone = $phone_number_query[0]->phone_number;
      } else {
          $salesphone = "{{Sales Phone Not Added!!}}"; 
      }

        $region_array = array('APAC','Europe','MENA','Canada','Latin America');
        if($getmname != 'APAC CIOoutlook'){
            foreach ($region_array as $region) {
                $get_magname = trim(str_replace($region, '', $getmname));
            }
        }else{
            $get_magname = 'APAC CIOoutlook';
        }

           $encripted_compose= self::encrypt_decrypt('encrypt', $unique_id);
            
           $signature_new = '<table style="width: 100%; line-height: 1.5; font-family: EuclidCircularB, Arial, Helvetica, sans-serif;">
    <tbody><tr>
        <td style="vertical-align: top; width: 38%;">
         <p style="font-size: 15px;">Best Regards,</p><p style="font-size: 18px;"><b>' . ucfirst($first_name_kk) . '  ' . ucfirst($last_name_kk) . ' |</b> ' . $get_magname . '</p>
            <p style="color: #686464; font-size: 14px;">Senior Relationship Specialist</p>
            <p style="font-size: 12px;">600 S Andrews Ave Suite 405, Fort Lauderdale, FL 33301</p>
            <p style="font-size: 12px;">Main: ' . $salesphone . '</p>
            <p><a href="'.$this->sender_email.'">'.$this->sender_email.'</a></p>
            <p>_______</p>
            </td>
            <td style="text-align: left;width: 35%;">
                <img src="https://www.'.$show_magurl.'/mme5n2pvn/website_logo.png?'.$encripted_compose.'" alt="Logo" style="max-width: 100%; height: auto;">
            </td>
            <td style="text-align: left;width: 27%;">
            </td>
        </tr>
    </tbody></table>';
    }


    $total_block = substr_count($mail_content, '<blockquote>');
    $gradient = array("Aqua", "Aquamarine", "Black", "Blue", "BlueViolet", "Brown", "CadetBlue", "DarkBlue", "DarkCyan", "DarkGreen", "DarkMagenta");
    for ($i = 0; $i < $total_block; $i++) {
      $rand_keys = array_rand($gradient, 2);
      $block_data = '<blockquote style="margin:0 0 0 .8ex;border-left:1px ' . $gradient[$rand_keys[0]] . ' solid;padding-left:1ex">';
      $from = '/' . preg_quote("<blockquote>", '/') . '/';

      $mail_content = preg_replace($from, $block_data, $mail_content, 1);
    }
    $strMailContent = "$mail_content";
    $caseStudyContent = $caseStudyContent2 = "";

    if ($subject_f == '{{subject}}') {
      if ($mail_type == 'First Mail' || $mail_type == 'Can We Schedule' || $mail_type == 'Can we schedule' || $mail_type == 'Reminder 2') {

        $filter_cond = " filter = 1";

        $check_Sunsum = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=1")->get();
          if(count($check_Sunsum)>0){
              $cont_id=$check_Sunsum[0]->content_id;
              $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              if($mail_type == 'Can We Schedule'){
                $subject_f = $get_subjectline[0]->content_line;
                $subject_f = "Re: " . $subject_f;
              }else{
                $subject_f = $get_subjectline[0]->content_line;
              }
              $filter_field5 = $get_subjectline[0]->id;
              $moving_limit_field5 = $get_subjectline[0]->moving_limit;
              $moving_limit_field5k = $moving_limit_field5 + 1;
          
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");            
          }else{
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
              $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where $filter_cond and flag=1");
            }
  
             
            $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_subjectline) > 0) {
              if($mail_type == 'Can We Schedule'){
                $subject_f = $get_subjectline[0]->content_line;
                $subject_f = "Re: " . $subject_f;
              }else{
                $subject_f = $get_subjectline[0]->content_line;
              }
              $filter_field5 = $get_subjectline[0]->id;
              $moving_limit_field5 = $get_subjectline[0]->moving_limit;
              $moving_limit_field5k = $moving_limit_field5 + 1;
  
               
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");
            } else {
              $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_subjectline) > 0) {
                if($mail_type == 'Can We Schedule'){
                $subject_f = $get_subjectline[0]->content_line;
                $subject_f = "Re: " . $subject_f;
              }else{
                $subject_f = $get_subjectline[0]->content_line;
              }
              $filter_field5 = $get_subjectline[0]->id;
                $moving_limit_field5 = $get_subjectline[0]->moving_limit;
                $moving_limit_field5k = $moving_limit_field5 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");
              }
            }
          }
      } else if ($mail_type == 'Reminder 1') {  
          $check_Sunsum = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=1")->get();
          if(count($check_Sunsum)>0){
              $cont_id=$check_Sunsum[0]->content_id;
              $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $subject_f = "Re: " . $get_subjectline[0]->content_line;
              $filter_field5 = $get_subjectline[0]->id;
              $moving_limit_field5 = $get_subjectline[0]->moving_limit;
              $moving_limit_field5k = $moving_limit_field5 + 1;
          
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");            
          }else{
             
            $get_firstmail = QB::query("select field5 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail'  and field5 != '' and field5 != 0 and field5 is not null and field5 != 'NULL' limit 1")->get();
            if (count($get_firstmail) > 0) {
              $get_fieldk5 = $get_firstmail[0]->field5;
              echo "<li>  *** "."select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk5 ";
              $get_subjectline1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk5 ")->get();
              if (count($get_subjectline1) > 0) {
                $subject_f = $get_subjectline1[0]->content_line;
                $subject_f = "Re: " . $subject_f;
                $filter_field5 = $get_subjectline1[0]->id;
              }
            } else {
              $filter_cond = " filter = 1";

              $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and moving_limit < 20")->get();
              $get_pend_cnt = $check_pending_data[0]->pend_cnt;
              if ($get_pend_cnt == 0) {
                $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where $filter_cond and flag=1");
              }

               
              $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_subjectline) > 0) {
                $subject_f = "Re: " . $get_subjectline[0]->content_line;
                $filter_field5 = $get_subjectline[0]->id;
                $moving_limit_field5 = $get_subjectline[0]->moving_limit;
                $moving_limit_field5k = $moving_limit_field5 + 1;

                 
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");
              } else {
                $get_subjectline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  $filter_cond and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_subjectline) > 0) {
                  $subject_f = "Re: " . $get_subjectline[0]->content_line;
                  $filter_field5 = $get_subjectline[0]->id;
                  $moving_limit_field5 = $get_subjectline[0]->moving_limit;
                  $moving_limit_field5k = $moving_limit_field5 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field5k, flag=1 where id=$filter_field5 limit 1");
                }
              }
            }
          }
        }
    }
    $check_unsubscribe_line = strpos($strMailContent, "{{unsubscribe_line}}");
    if ($check_unsubscribe_line !== false) {
      if ($mail_type == 'First Mail') {

      $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=2")->get();
      if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              if (count($get_unsubscribeline) > 0) {
              $unsubscribe_word = $get_unsubscribeline[0]->content_line;
              $filter_field6 = $get_unsubscribeline[0]->id;
              $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
              $moving_limit_field6k = $moving_limit_field6 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
              }else{
                $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_unsubscribeline) > 0) {
                  $unsubscribe_word = $get_unsubscribeline[0]->content_line;
                  $filter_field6 = $get_unsubscribeline[0]->id;
                  $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
                  $moving_limit_field6k = $moving_limit_field6 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
                }
              }
              
      }else{
        $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and moving_limit < 20")->get();
        $get_pend_cnt = $check_pending_data[0]->pend_cnt;
        if ($get_pend_cnt == 0) {
          $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 4 and flag=1");
        }

        $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
        if (count($get_unsubscribeline) > 0) {
          $unsubscribe_word = $get_unsubscribeline[0]->content_line;
          $filter_field6 = $get_unsubscribeline[0]->id;
          $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
          $moving_limit_field6k = $moving_limit_field6 + 1;
          $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
        } else {
          $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
          if (count($get_unsubscribeline) > 0) {
            $unsubscribe_word = $get_unsubscribeline[0]->content_line;
            $filter_field6 = $get_unsubscribeline[0]->id;
            $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
            $moving_limit_field6k = $moving_limit_field6 + 1;
            $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
          }
        }
      }
        $unsubscribe_line_word_count = str_word_count($unsubscribe_word);
        if ($unsubscribe_line_word_count < 5) {
          $blockmail = 1;
          $return_val = "unsubscribe_line_is_less_than_five_words";
        }
      }else {
        $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=2")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              if (count($get_unsubscribeline) > 0) {
              $unsubscribe_word = $get_unsubscribeline[0]->content_line;
              $filter_field6 = $get_unsubscribeline[0]->id;
              $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
              $moving_limit_field6k = $moving_limit_field6 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
              }else{
                $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_unsubscribeline) > 0) {
                  $unsubscribe_word = $get_unsubscribeline[0]->content_line;
                  $filter_field6 = $get_unsubscribeline[0]->id;
                  $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
                  $moving_limit_field6k = $moving_limit_field6 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
                }
              }
              
          }else{

        // $get_firstmail = QB::query("select field6 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail' and field6 != '' and field6 != 0  and field6 is not null and field6 != 'NULL'limit 1")->get();
//         if (count($get_firstmail) > 0) {
//           $get_fieldk6 = $get_firstmail[0]->field6;
//           $get_unsubsline1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk6 ")->get();
//           if (count($get_unsubsline1) > 0) {
//             $unsubscribe_word = $get_unsubsline1[0]->content_line;
//             $filter_field6 = $get_unsubsline1[0]->id;
//             $unsubscribe_line_word_count = str_word_count($unsubscribe_word);
//             if ($unsubscribe_line_word_count < 5) {
//               $blockmail = 1;
//               $return_val = "unsubscribe_line_is_less_than_five_words";
//             }
//           }
//         }else{
          $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and moving_limit < 20")->get();
          $get_pend_cnt = $check_pending_data[0]->pend_cnt;
          if ($get_pend_cnt == 0) {
            $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 4 and flag=1");
          }

          $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
          if (count($get_unsubscribeline) > 0) {
            $unsubscribe_word = $get_unsubscribeline[0]->content_line;
            $filter_field6 = $get_unsubscribeline[0]->id;
            $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
            $moving_limit_field6k = $moving_limit_field6 + 1;
            $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
          } else {
            $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_unsubscribeline) > 0) {
              $unsubscribe_word = $get_unsubscribeline[0]->content_line;
              $filter_field6 = $get_unsubscribeline[0]->id;
              $moving_limit_field6 = $get_unsubscribeline[0]->moving_limit;
              $moving_limit_field6k = $moving_limit_field6 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field6k, flag=1 where id=$filter_field6 limit 1");
            }
          }
        // }
        $unsubscribe_line_word_count = str_word_count($unsubscribe_word);
        if ($unsubscribe_line_word_count < 5) {
          $blockmail = 1;
          $return_val = "unsubscribe_line_is_less_than_five_words";
        }
        }
      }
    }


    $check_first_line = strpos($strMailContent, "{{first_line}}");
      if ($check_first_line !== false) {
        if ($mail_type == 'First Mail') {
          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=6")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $first_word = $get_firstline[0]->content_line;
              $filter_field8 = $get_firstline[0]->id;
              $moving_limit_field8 = $get_firstline[0]->moving_limit;
              $moving_limit_field8k = $moving_limit_field8 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
              
          }else{
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
              $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 6 and flag=1");
            }

            $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_firstline) > 0) {
              $first_word = $get_firstline[0]->content_line;
              $filter_field8 = $get_firstline[0]->id;
              $moving_limit_field8 = $get_firstline[0]->moving_limit;
              $moving_limit_field8k = $moving_limit_field8 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
            } else {
              $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_firstline) > 0) {
                $first_word = $get_firstline[0]->content_line;
                $filter_field8 = $get_firstline[0]->id;
                $moving_limit_field8 = $get_firstline[0]->moving_limit;
                $moving_limit_field8k = $moving_limit_field8 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
              }
            }
          }
          $first_line_word_count = str_word_count($first_word);
          if ($first_line_word_count < 5) {
            $blockmail = 1;
            $return_val = "first_line_is_less_than_five_words";
          }
        } else {

          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=6")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $first_word = $get_firstline[0]->content_line;
              $filter_field8 = $get_firstline[0]->id;
              $moving_limit_field8 = $get_firstline[0]->moving_limit;
              $moving_limit_field8k = $moving_limit_field8 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
              
          }else{
            $get_firstmail = QB::query("select field8 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail' and field8 != ''  and field8 != 0 and field8 is not null and field8 != 'NULL'limit 1")->get();
            if (count($get_firstmail) > 0) {
              $get_fieldk8 = $get_firstmail[0]->field8;
              $get_unsubsline1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk8 ")->get();
              if (count($get_unsubsline1) > 0) {
                $first_word = $get_unsubsline1[0]->content_line;
                $filter_field8 = $get_unsubsline1[0]->id;
                $first_line_word_count = str_word_count($first_word);
                if ($first_line_word_count < 5) {
                  $blockmail = 1;
                  $return_val = "first_line_is_less_than_five_words";
                }
              }
            } else {
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
                $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 6 and flag=1");
              }

              $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_firstline) > 0) {
                $first_word = $get_firstline[0]->content_line;
                $filter_field8 = $get_firstline[0]->id;
                $moving_limit_field8 = $get_firstline[0]->moving_limit;
                $moving_limit_field8k = $moving_limit_field8 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
              } else {
                $get_firstline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 6 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_firstline) > 0) {
                  $first_word = $get_firstline[0]->content_line;
                  $filter_field8 = $get_firstline[0]->id;
                  $moving_limit_field8 = $get_firstline[0]->moving_limit;
                  $moving_limit_field8k = $moving_limit_field8 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field8k, flag=1 where id=$filter_field8 limit 1");
                }
              }
              $first_line_word_count = str_word_count($first_word);
              if ($first_line_word_count < 5) {
                $blockmail = 1;
                $return_val = "first_line_is_less_than_five_words";
              }
            }
          }
        }
      }


      $check_cost_para = strpos($strMailContent, "{{cost_para}}");
      if ($check_cost_para !== false) {
        if ($mail_type == 'First Mail') {
          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=7")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $cost_word = $get_costpara[0]->content_line;
              $filter_field9 = $get_costpara[0]->id;
              $moving_limit_field9 = $get_costpara[0]->moving_limit;
              $moving_limit_field9k = $moving_limit_field9 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
              
          }else{
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
              $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 7 and flag=1");
            }

             $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_costpara) > 0) {
              $cost_word = $get_costpara[0]->content_line;
              $filter_field9 = $get_costpara[0]->id;
              $moving_limit_field9 = $get_costpara[0]->moving_limit;
              $moving_limit_field9k = $moving_limit_field9 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
            } else {
              $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_costpara) > 0) {
                $cost_word = $get_costpara[0]->content_line;
                $filter_field9 = $get_costpara[0]->id;
                $moving_limit_field9 = $get_costpara[0]->moving_limit;
                $moving_limit_field9k = $moving_limit_field9 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
              }
            }
          }
          $cost_para_word_count = str_word_count($cost_word);
          if ($cost_para_word_count < 5) {
            $blockmail = 1;
            $return_val = "cost_para_is_less_than_five_words";
          }
        } else {

          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=7")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id;
              $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $cost_word = $get_costpara[0]->content_line;
              $filter_field9 = $get_costpara[0]->id;
              $moving_limit_field9 = $get_costpara[0]->moving_limit;
              $moving_limit_field9k = $moving_limit_field9 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
              
          }else{
            $get_firstmail = QB::query("select field9 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail' and field9 != ''  and field9 != 0 and field9 is not null and field9 != 'NULL'limit 1")->get();
            if (count($get_firstmail) > 0) {
              $get_fieldk9 = $get_firstmail[0]->field9;
              $get_costpara1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk9 ")->get();
              if (count($get_costpara1) > 0) {
                $cost_word = $get_costpara1[0]->content_line;
                $filter_field9 = $get_costpara1[0]->id;
                $cost_para_word_count = str_word_count($cost_word);
                if ($cost_para_word_count < 5) {
                  $blockmail = 1;
                  $return_val = "cost_para_is_less_than_five_words";
                }
              }
            } else {
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
                $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 7 and flag=1");
              }

              $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_costpara) > 0) {
                $cost_word = $get_costpara[0]->content_line;
                $filter_field9 = $get_costpara[0]->id;
                $moving_limit_field9 = $get_costpara[0]->moving_limit;
                $moving_limit_field9k = $moving_limit_field9 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
              } else {
                $get_costpara = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 7 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_costpara) > 0) {
                  $cost_word = $get_costpara[0]->content_line;
                  $filter_field9 = $get_costpara[0]->id;
                  $moving_limit_field9 = $get_costpara[0]->moving_limit;
                  $moving_limit_field9k = $moving_limit_field9 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field9k, flag=1 where id=$filter_field9 limit 1");
                }
              }
              $cost_para_word_count = str_word_count($cost_word);
              if ($cost_para_word_count < 5) {
                $blockmail = 1;
                $return_val = "cost_para_is_less_than_five_words";
              }
            }
          }
        }
      }


      $check_disclaimer = strpos($strMailContent, "{{disclaimer}}");
      if ($check_disclaimer !== false) {
        if ($mail_type == 'First Mail') {
          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=8")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id; 
              $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $disclaimer_word = $get_disclaimer[0]->content_line;
              $filter_field10 = $get_disclaimer[0]->id;
              $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
              $moving_limit_field10k = $moving_limit_field10 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
              
          }else{
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
              $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 8 and flag=1");
            }

            $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_disclaimer) > 0) {
              $disclaimer_word = $get_disclaimer[0]->content_line;
              $filter_field10 = $get_disclaimer[0]->id;
              $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
              $moving_limit_field10k = $moving_limit_field10 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
            } else {
              $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_disclaimer) > 0) {
                $disclaimer_word = $get_disclaimer[0]->content_line;
                $filter_field10 = $get_disclaimer[0]->id;
                $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
                $moving_limit_field10k = $moving_limit_field10 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
              }
            }
          }
          $disclaimer_word_count = str_word_count($disclaimer_word);
          if ($disclaimer_word_count < 5) {
            $blockmail = 1;
            $return_val = "disclaimer_is_less_than_five_words";
          }
        } else {

          $check_unsub = QB::query("select content_id from projectwise_sub_unsubs_tracking_details where pid=$project_sel_f and flag=8")->get();
          if(count($check_unsub)>0){
              $cont_id=$check_unsub[0]->content_id; 
              $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  id=$cont_id LIMIT 1")->get();
              $disclaimer_word = $get_disclaimer[0]->content_line;
              $filter_field10 = $get_disclaimer[0]->id;
              $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
              $moving_limit_field10k = $moving_limit_field10 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
              
          }else{
            $get_firstmail = QB::query("select field10 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail' and field10 != ''  and field10 != 0 and field10 is not null and field10 != 'NULL'limit 1")->get();
            if (count($get_firstmail) > 0) {
              $get_fieldk10 = $get_firstmail[0]->field10;
              $get_unsubsline1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk10 ")->get();
              if (count($get_unsubsline1) > 0) {
                $disclaimer_word = $get_unsubsline1[0]->content_line;
                $filter_field10 = $get_unsubsline1[0]->id;
                $disclaimer_word_count = str_word_count($disclaimer_word);
                if ($disclaimer_word_count < 5) {
                  $blockmail = 1;
                  $return_val = "disclaimer_is_less_than_five_words";
                }
              }
            } else {
            $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and moving_limit < 20")->get();
            $get_pend_cnt = $check_pending_data[0]->pend_cnt;
            if ($get_pend_cnt == 0) {
                $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 8 and flag=1");
              }

              $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_disclaimer) > 0) {
                $disclaimer_word = $get_disclaimer[0]->content_line;
                $filter_field10 = $get_disclaimer[0]->id;
                $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
                $moving_limit_field10k = $moving_limit_field10 + 1;
                $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
              } else {
                $get_disclaimer = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 8 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
                if (count($get_disclaimer) > 0) {
                  $disclaimer_word = $get_disclaimer[0]->content_line;
                  $filter_field10 = $get_disclaimer[0]->id;
                  $moving_limit_field10 = $get_disclaimer[0]->moving_limit;
                  $moving_limit_field10k = $moving_limit_field10 + 1;
                  $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field10k, flag=1 where id=$filter_field10 limit 1");
                }
              }
              $disclaimer_word_count = str_word_count($disclaimer_word);
              if ($disclaimer_word_count < 5) {
                $blockmail = 1;
                $return_val = "disclaimer_is_less_than_five_words";
              }
            }
          }
        }
      }


      $check_lastline = strpos($strMailContent, "{{last_line}}");
    if ($check_lastline !== false) {
      if ($mail_type == 'First Mail') {

        $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and moving_limit < 20")->get();
        $get_pend_cnt = $check_pending_data[0]->pend_cnt;
        if ($get_pend_cnt == 0) {
          $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 5  and flag=1");
        }


        $get_lastline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
        if (count($get_lastline) > 0) {
          $lastline_word = $get_lastline[0]->content_line;
          $filter_field7 = $get_lastline[0]->id;
          $moving_limit_field7 = $get_lastline[0]->moving_limit;
          $moving_limit_field7k = $moving_limit_field7 + 1;
          $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field7k, flag=1 where id=$filter_field7 limit 1");
        } else {
          $get_lastline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
          if (count($get_lastline) > 0) {
            $lastline_word = $get_lastline[0]->content_line;
            $filter_field7 = $get_lastline[0]->id;
            $moving_limit_field7 = $get_lastline[0]->moving_limit;
            $moving_limit_field7k = $moving_limit_field7 + 1;
            $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field7k, flag=1 where id=$filter_field7 limit 1");
          }
        }
        $lastLine_word_count = str_word_count($lastline_word);
        if ($lastLine_word_count < 5) {
          $blockmail = 1;
          $return_val = "lastline_is_less_than_five_words";
        }
      } else{
        $get_firstmail = QB::query("select field7 from d3_compose where cid = $compny_id and pid=$project_sel_f and receiver_email ='$receiver_email_id' and mail_type = 'First Mail' and field7 != '' and field7 != 0 and field7 is not null and field7 != 'NULL' limit 1")->get();
        if (count($get_firstmail) > 0) {
          $get_fieldk7 = $get_firstmail[0]->field7;
          // if (!is_string($get_fieldk7)) {
          $get_lastline1 = QB::query("select content_line,id from proposal_sub_unsubs_lastline_details where active_status!=2 and  id = $get_fieldk7 ")->get();
          if (count($get_lastline1) > 0) {
            $lastline_word = $get_lastline1[0]->content_line;
            $filter_field7 = $get_lastline1[0]->id;
            $lastLine_word_count = str_word_count($lastline_word);
            if ($lastLine_word_count < 5) {
              $blockmail = 1;
              $return_val = "lastline_is_less_than_five_words";
            }
          }
          // }
        }else{
          $check_pending_data = QB::query("select count(id) pend_cnt from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and moving_limit < 20")->get();
          $get_pend_cnt = $check_pending_data[0]->pend_cnt;
          if ($get_pend_cnt == 0) {
            $update_pro_pend = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit = 0,flag=0 where filter = 5  and flag=1");
          }

          $get_lastline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
          if (count($get_lastline) > 0) {
            $lastline_word = $get_lastline[0]->content_line;
            $filter_field7 = $get_lastline[0]->id;
            $moving_limit_field7 = $get_lastline[0]->moving_limit;
            $moving_limit_field7k = $moving_limit_field7 + 1;
            $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field7k, flag=1 where id=$filter_field7 limit 1");
          } else {
            $get_lastline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 5 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_lastline) > 0) {
              $lastline_word = $get_lastline[0]->content_line;
              $filter_field7 = $get_lastline[0]->id;
              $moving_limit_field7 = $get_lastline[0]->moving_limit;
              $moving_limit_field7k = $moving_limit_field7 + 1;
              $update_unsb = QB::query("update proposal_sub_unsubs_lastline_details set moving_limit=$moving_limit_field7k, flag=1 where id=$filter_field7 limit 1");
            }
          }
          $lastLine_word_count = str_word_count($lastline_word);
          if ($lastLine_word_count < 5) {
            $blockmail = 1;
            $return_val = "lastline_is_less_than_five_words";
          }
        }
      }
    }

    if ($filter_field7 != '' || $filter_field6 != '' || $filter_field5 != '' || $filter_field8 != '' || $filter_field9 != '' || $filter_field10 != '') {
        if ($filter_field7 == '') {
          $filter_field7 = 0;
        }
        if ($filter_field6 == '') {
          $filter_field6 = 0;
        }
        if ($filter_field5 == '') {
          $filter_field5 = 0;
        }
        if ($filter_field8 == '') {
          $filter_field8 = 0;
        }
        if ($filter_field9 == '') {
          $filter_field9 = 0;
        }
        if ($filter_field10 == '') {
          $filter_field10 = 0;
        }
        $update_d3 = QB::query("update d3_compose set field5 = $filter_field5 , field6=$filter_field6 , field7 = $filter_field7, field8 = $filter_field8, field9 = $filter_field9, field10 = $filter_field10 where id=$unique_id limit 1");
      }

    $today = date('Y-m-d');
    echo "\n select * from master_companies where cid = $compny_id and rank in (10,11)";

    if ($compny_id != '') {
      // $select_check_rank = QB::query("select * from master_companies where cid = $compny_id and `rank` in (10,11)")->get();
      // $proinfo = QB::query("select pro_info from projectinfo where pid = $project_sel_f  and pro_info != '' and pro_info is not null")->get();
      // $search = "{{differentmagazine}}";
      // if (count($select_check_rank) > 0) {
      //   if (isset($old_mag) && !empty($old_mag) && !is_null($old_mag)) {
      //     if ($add_magid != $old_mag) {
      //       if (count($proinfo) > 0) {
      //         $proinfodata = $proinfo[0]->pro_info;
      //         $glad_cnt = "I am glad to inform you that {{newmagazine}} and {{oldmagazine}} belong to the same organization.";
      //         $strMailContent = str_replace("{{differentmagazine}}", $glad_cnt, $strMailContent);
      //         $strMailContent = str_replace("{{aboutMagazine}}", $proinfodata, $strMailContent);
      //       } else {
      //         $blockmail = 1;
      //       }
      //     } else {
      //       $strMailContent = str_replace("{{aboutMagazine}}", "", $strMailContent);
      //       $strMailContent = str_replace("{{differentmagazine}}", "", $strMailContent);
      //     }
      //   } else {
      //     $blockmail = 1;
      //   }
      // }

      if($oldmagazine != $getmname){
        $differentoldmagazine_val = "which belongs to the same organization that owns {{oldmagazine}}.";
        $strMailContent = str_replace("{{differentoldmagazine}}",$differentoldmagazine_val,$strMailContent);      
      }else{
        $strMailContent = str_replace("{{differentoldmagazine}}",'',$strMailContent);  
      }

      $check_rankkk = QB::query("select `rank`,curl from master_companies where cid = $compny_id and `rank` in (5,10,11)")->get();
      if (count($check_rankkk) > 0) {
        $check_rankkk_curl = $check_rankkk[0]->curl;
        $check_rankkk_rank = $check_rankkk[0]->rank;

        $fetch_htmllink = QB::query("select cid,p3_status from master_companies where curl = '$check_rankkk_curl' and status=1 order by cid desc limit 1")->get();
        if (count($fetch_htmllink) > 0) {
          $fetch_old_cid = $fetch_htmllink[0]->cid;
            $old_p3_status = $fetch_htmllink[0]->p3_status;
            $pick_oldcategory = QB::query("select status_name from emailprocess.companytype_status where status='$old_p3_status'")->get();
            if(count($pick_oldcategory)>0){
              $old_status_name = $pick_oldcategory[0]->status_name;
            }else{
              $old_status_name = '{{old_project_category}}';
            }
          $get_html_link = QB::query("select new_website_link from cwf.cwf_sold_companies where compayny_id=$fetch_old_cid ")->get();
          $old_new_website_link = $get_html_link[0]->new_website_link;
        }
        $picked_status=0;
          $pick_procat = QB::query("select status from past_year_closures_track  where cid=$compny_id and active_status=1 limit 1")->get();
          if(count($pick_procat)>0){                        
            $picked_status = $pick_procat[0]->status;
          }else{
            $return_val = "past_closer_project_category";
            return $return_val;
            $blockmail = 1;
          }

          if($oldmagazine != $getmname){
            if($picked_status == 1){
              $closed_client_1k = "I am thrilled to inform you that we had worked together in the past for {{oldmagazine}}'s edition on {{oldproject}}. We would like to thank you for your efforts in collaborating with {{oldmagazine}}, which belongs to the same organization that owns {{magazinename}}.";
            }elseif($picked_status == 2){
              $closed_client_1k = "I am thrilled to inform you that we had worked together in the past for the Top {{old_project_category}} feature in {{oldmagazine}}. We would like to thank you for your efforts in collaborating with {{oldmagazine}}, which belongs to the same organization that owns {{magazinename}}.";
            }
            
        }else{
          if($picked_status == 1){
            $closed_client_1k = "I am thrilled to inform you that we have worked together in the past for {{oldmagazine}}'s edition on {{oldproject}}. We would like to thank you for your efforts in collaborating with us.";
          }elseif($picked_status == 2){
            $closed_client_1k = "I am thrilled to inform you that we have worked together in the past for the Top {{old_project_category}} feature in {{oldmagazine}}. We would like to thank you for your efforts in collaborating with us.";
          }
        }

        $closed_client_3k = "Here’s the link to {{company}}’s current profile in {{magazinename}}: {{companypreviousprofile}}";

        $closed_client_2k = "I am excited to let you know that your current profile from {{oldmagazine}} has been receiving a great response from our readers. In the past 30 days alone, {{company}}’s profile page has received about {{traffic_view}} page views and {{traffic_click}} clicks from visitors who were highly intrigued by {{company}}’s expertise and compelled to explore more; ultimately, lead to visit your website from {{oldmagazinewithlink}}.";

        $rank5_closed = 0;
                  if (($project_print_online_hold_status == 0 || $project_print_online_hold_status == 1 || $project_print_online_hold_status == 2 || $project_print_online_hold_status == 3 || $project_print_online_hold_status == 4) && $project_closed_status == 0) {
                    $rank5_closed = 1;
                    
                    $strMailContent = str_replace("{{closedcontent2}}",'',$strMailContent);
                    $strMailContent = str_replace("{{closedcontent3}}",'',$strMailContent);
                  }else{
                    
                    $strMailContent = str_replace("{{closedcontent2}}",$closed_client_2k,$strMailContent);
                    $strMailContent = str_replace("{{closedcontent3}}",$closed_client_3k,$strMailContent);
                  }
        $strMailContent = str_replace("{{closedcontent1}}",$closed_client_1k,$strMailContent);
        $strMailContent = str_replace("{{old_project_category}}",$old_status_name,$strMailContent);
        $strMailContent = str_replace("{{magazinename}}", $getmname, $strMailContent);
        $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
        $strMailContent = str_replace("{{magazinewithlink_new}}", $mnameurl_new, $strMailContent);
        $strMailContent = str_replace("{{oldmagazinewithlink}}", $oldmnameurl, $strMailContent);
        $strMailContent = str_replace("{{companypreviousprofile}}", $old_new_website_link, $strMailContent);

        $check_online = QB::query("select date(online_date) online_date from projectinfo p join master_companies m on m.pid=p.pid where curl='$check_rankkk_curl' and m.status=1 order by cid desc limit 1")->get();
        $dateToCheck = $check_online[0]->online_date;
        $currentTimestamp = time();
        $targetTimestamp = strtotime($dateToCheck);
        $oneYearFromNowTimestamp = strtotime('-1 year');
        // if (($targetTimestamp > $oneYearFromNowTimestamp) || $check_rankkk_rank == 5) {
          $closure_magazine = QB::query("select pid from master_companies where curl='$check_rankkk_curl' and status=1 order by cid desc limit 1")->get();
                $get_closures_pid = $closure_magazine[0]->pid;
                $get_closures_magid = self::magazine_id($get_closures_pid);
               if($get_closures_magid !=''){
                  $closure_magaizne = QB::query("select count(*) magid_count from magazine_details where magid =$get_closures_magid and magazine_status = 0")->get();
                  $magidcount = $closure_magaizne[0]->magid_count;
                }
$listing_comp = QB::query("select count(*) listing_count from traffic_restrictions where cid =$compny_id")->get();
                  $listcount = $listing_comp[0]->listing_count;

          $check_p1_kj = QB::query("select count(*) p1_cnt from addperson_detail where cid=$compny_id and email_id = '$receiver_email_id' and person_type = 'P1'")->get();
                  $p1_counts= $check_p1_kj[0]->p1_cnt;
          if ((($check_rankkk_rank == 5 || $check_rankkk_rank == 10 || $check_rankkk_rank == 11) && $rank5_closed == 0) && $magidcount == 0 && $listcount == 0) {
          if ($mail_type == 'First Mail'  && $p1_counts > 0) {
            $check_traffic = QB::query("select ttl_click,ttl_view from traffic_click_view_rank_details where url ='$check_rankkk_curl' order by date(addeddate) desc,ttl_click desc limit 1")->get();
            if (count($check_traffic) > 0) {
              $get_traffic_click = $check_traffic[0]->ttl_click;
              $get_traffic_view = $check_traffic[0]->ttl_view;

              if ($get_traffic_click >= 60) {
                $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
              } else {
                $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                if (count($check_notmoved) == 0) {
                  $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl', $get_traffic_click, '$get_traffic_view', 'Traffic click count is low', now())");
                } else {
                  $check_notmoved_id = $check_notmoved[0]->id;
                  $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=$get_traffic_click , traffic_view='$get_traffic_view',comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
                }
                $return_val = "traffic_count_is_low";
                return $return_val;
                $blockmail = 1;
              }
            } else {
              $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
              if (count($check_notmoved) == 0) {
                $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl',0, 0, 'Traffic click count is low', now())");
              } else {
                $check_notmoved_id = $check_notmoved[0]->id;
                $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=0 , traffic_view=0,comment='Traffic Not Added' where id=$check_notmoved_id limit 1");
              }
              $return_val = "no_traffic_count";
                return $return_val;
              $blockmail = 1;
            }
          } else {

            $check_firstmail_date = QB::query("select date(send_date) send_date from d3_compose where cid=$compny_id  and mail_type = 'First Mail' and send_date is not null and send_date!='0000-00-00 00:00:00' limit 1")->get();
            if (count($check_firstmail_date) > 0) {
              $firstmail_sent_date = $check_firstmail_date[0]->send_date;
              $check_traffic_fm = QB::query("select ttl_click,ttl_view from traffic_click_view_rank_details where date(addeddate) <= '$firstmail_sent_date' and url ='$check_rankkk_curl' order by date(addeddate) desc,ttl_click desc limit 1")->get();
              if (count($check_traffic_fm) > 0) {
                $get_traffic_click = $check_traffic_fm[0]->ttl_click;
                $get_traffic_view = $check_traffic_fm[0]->ttl_view;

                if ($get_traffic_click >= 60) {
                  $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                  $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
                } else {
                  $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                  if (count($check_notmoved) == 0) {
                    $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl', $get_traffic_click, '$get_traffic_view', 'Traffic click count is low', now())");
                  } else {
                    $check_notmoved_id = $check_notmoved[0]->id;
                    $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=$get_traffic_click , traffic_view='$get_traffic_view',comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
                  }
                  $return_val = "traffic_count_is_low";
                return $return_val;
                  $blockmail = 1;
                }
              } else {
                $check_traffic = QB::query("select ttl_click,ttl_view from traffic_click_view_rank_details where url ='$check_rankkk_curl' order by date(addeddate) desc,ttl_click desc limit 1")->get();
                          if(count($check_traffic)>0){
                            $get_traffic_click = $check_traffic[0]->ttl_click;
                            $get_traffic_view = $check_traffic[0]->ttl_view;

                            if($get_traffic_click >= 30){
                              $strMailContent = str_replace("{{traffic_click}}",$get_traffic_click,$strMailContent);
                              $strMailContent = str_replace("{{traffic_view}}",$get_traffic_view,$strMailContent); 
                            }else{
                              $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                              if(count($check_notmoved) == 0){
                                $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl', $get_traffic_click, '$get_traffic_view', 'Traffic click count is low', now())");
                              }else{
                                $check_notmoved_id = $check_notmoved[0]->id;
                                $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=$get_traffic_click , traffic_view='$get_traffic_view',comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
                              }
                              $return_val = "traffic_count_is_low";
                              return $return_val;
                              $blockmail = 1;
                            }
                          }else{
                            $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                            if(count($check_notmoved) == 0){
                              $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl',0, 0, 'Traffic click count is low', now())");
                            }else{
                              $check_notmoved_id = $check_notmoved[0]->id;
                              $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=0 , traffic_view=0,comment='Traffic Not Added' where id=$check_notmoved_id limit 1");
                            }
                            $return_val = "no_traffic_count";
                            return $return_val;
                            $blockmail = 1;
                          }
              }
            }
          }
        }
      }
    }

    if (($magid == 1 || $magid == 49) && strpos($strMailContent, "{{casestudypara1}}") !== false && $draft_name == 'Past Client' && $project_sel_f != 3092 && $project_sel_f != 2577) {

      $getPastClientCount = QB::query("select * from emailprocess.master_companies_track where cid=$compny_id and pid=$project_sel_f and action_type='casestudy past client'")->get();
      if (count($getPastClientCount) == 0) {
        $query = QB::query("insert into emailprocess.master_companies_track (cid,pid,uid,action_type,date) values($compny_id,$project_sel_f,$this->log_userId,'casestudy past client',now())");
      }

      $strMailContent = str_replace("{{casestudypara1}}", $caseStudyContent, $strMailContent);
      $strMailContent = str_replace("{{casestudypara2}}", $caseStudyContent2, $strMailContent);
    } else {
      $strMailContent = str_replace("{{casestudypara1}}", "", $strMailContent);
      $strMailContent = str_replace("{{casestudypara2}}", "", $strMailContent);
    }

    if ($compny_id != '') {
      $select_check_rank = QB::query("select * from master_companies where cid = $compny_id and `rank` in (10,11)")->get();
      $proinfo = QB::query("select pro_info from projectinfo where pid = $project_sel_f  and pro_info != '' and pro_info is not null")->get();
      $search = "{{differentmagazine}}";
      if (preg_match("/{$search}/i", $strMailContent) &&  count($select_check_rank) > 0) {
        if (isset($old_mag) && !empty($old_mag) && !is_null($old_mag)) {
          if ($add_magid != $old_mag) {
            if (count($proinfo) > 0) {
              $proinfodata = $proinfo[0]->pro_info;
              $glad_cnt = "I am glad to inform you that {{newmagazine}} and {{oldmagazine}} belong to the same organization.";
              $strMailContent = str_replace("{{differentmagazine}}", $glad_cnt, $strMailContent);
              $strMailContent = str_replace("{{aboutMagazine}}", $proinfodata, $strMailContent);
            } else {
              $blockmail = 1;
            }
          } else {
            $strMailContent = str_replace("{{aboutMagazine}}", "", $strMailContent);
            $strMailContent = str_replace("{{differentmagazine}}", "", $strMailContent);
          }
        } else {
          $blockmail = 1;
        }
      }
    }

    $info_content =  "";
    $strMailContent = str_replace("{{info}}", $info_content, $strMailContent);
    $strMailContent = str_replace("{{casestudypara1}}", "", $strMailContent);
    $strMailContent = str_replace("{{casestudypara2}}", "", $strMailContent);
    $batchh = self::getBatch($compny_id);

    $select_marketing_pid = QB::query("select pid from marketing_project where pid =$project_sel_f")->get();
    $count_marketing = count($select_marketing_pid);
    $bulk_exception = self::getExceptionBulk($compny_id);
    $bulk = $bulk_exception[bulk];
    $exception = $bulk_exception[exception];
    if (($batchh == 'BClient') || (($exception == 2) && ($bulk != 2000 && $bulk != 5000)) && $count_marketing == 0) {
      $field7 = "<br><br>" . $field7;
    }

    $p1person_name = '';
    $receiver_emaill =  $receiver_email_id;
    $pidd = $project_sel_f;

    $sender_fname_k = $sender_lname_k = '';
    echo "\n sum select f_name,l_name from proposal_fname_details where pid=$project_sel_f";
    $get_sender_fname = QB::query("select f_name,l_name from proposal_fname_details where pid=$project_sel_f")->get();
    if (count($get_sender_fname) > 0) {
      $sender_fname_k = $get_sender_fname[0]->f_name;
      $sender_lname_k = $get_sender_fname[0]->l_name;
    }
    if($lastline_word == ''){
      $lastline_word = "{{last_line}}";
    }
    if ($unsubscribe_word == '') {
      $unsubscribe_word = "{{unsubscribe_line}}";
    }
    if ($first_word == '') {
      $first_word = "{{first_line}}";
    }
    if ($cost_word == '') {
      $cost_word = "{{cost_para}}";
    }
    if ($disclaimer_word == '') {
      $disclaimer_word = "{{disclaimer}}";
    }
    if($sender_fname_k == ''){
      $sender_fname_k = "{{sender_fname}}";
    }
    if($sender_lname_k == ''){
      $sender_lname_k = "{{sender_lname}}";
    }
    if($getmname == ''){
      $getmname = "{{newmagazine}}";
    }
    if($getpname2 == ''){
      $getpname2 = "{{newproject}}";
    }
    if($getpname == ''){
      $getpname = "{{newprojectwithyear}}";
    }
    if($receiver_name == ''){
      $receiver_name = "{{name}}";
    }
    if($lname == ''){
      $lname = "{{lname}}";
    }
    //   if($add_person_id == ''){
            //     $add_person_id = "{{person_id}}";
            //   }
    if($unique_id == ''){
      $unique_id = "{{receiver_id}}";
    }
    if($company_name == ''){
      $company_name = "{{company}}";
    }
    if($designation_email_f == ''){
      $designation_email_f = "{{designation}}";
    }
    if($this->sender_name == ''){
      $this->sender_name = "{{sender_name}}";
    }
    if($field5 == ''){
      $field5 = "{{field5}}";
    }
    if($field6 == ''){
      $field6 = "{{field6}}";
    }

    if($signature_new == ''){
        $signature_new = "{{signature}}";
      }
      $signature_new = str_replace("Canada", '', $signature_new);
      $signature_new = str_replace("Latin America", '', $signature_new);
    if($aboutMagazine == ''){
      $aboutMagazine = "{{aboutMagazine}}";
    }
    if($oldmagazine == ''){
      $oldmagazine = "{{oldmagazine}}";
    }
    if($oldproject == ''){
      $oldproject = "{{oldproject}}";
    }
    if($field7 == ''){
      $field7 = "{{closedcontent}}";
    }
    if($p1person_name == ''){
      $p1person_name = "{{p1person_name}}";
    }
    if($first_name_kk == ''){
      $first_name_kk = "{{firstname}}";
    }
    if($last_name_kk == ''){
      $last_name_kk = "{{lastname}}";
    }
   $get_jobtitle = QB::query("select jobtitle from job_title where pid=$project_sel_f and category = $p3_status_kk and flag=0")->get();
      if(count($get_jobtitle)>0){
        $jobtitles= $get_jobtitle[0]->jobtitle;
      }else{
        $jobtitles="{{jobtitles}}";
      }
      $getpro_category = QB::query("select link_flag from project_category_linked where pid=$project_sel_f and cat_status_id = $p3_status_kk")->get();
      if(count($getpro_category)>0){
        $linkflags= $getpro_category[0]->link_flag;
        if($linkflags == 1){
          $get_categiryname = QB::query("select status_name from emailprocess.companytype_status where status=$p3_status_kk and project_id=$project_sel_f limit 1")->get();
          if(count($get_categiryname)>0){
            $project_category = $get_categiryname[0]->status_name;
          }else{
            $project_category="{{project_category}}";
          }
        }else{
          $project_category = $getpname2;
        }
      }else{
        $project_category="{{project_category}}";
      }
      $general_category_cnt=0;
      $take_refid = QB::query("select content_ref_id from d3_compose where id=$unique_id")->get();
      $ref_idkk = $take_refid[0]->content_ref_id;
      $general_category_val = QB::query("select count(id) general_cnt from session_content where id = $ref_idkk and general_category_flag=1")->get();
      $general_category_cnt = $general_category_val[0]->general_cnt;

      $check_category_pro = QB::query("select count(id) cp_cnt from categorized_projects where pid=$project_sel_f")->get();
      $cnt_cate_pro = $check_category_pro[0]->cp_cnt;
      if($cnt_cate_pro > 0 || $general_category_cnt > 0){
        $get_categiryname = QB::query("select status_name from emailprocess.companytype_status where status=$p3_status_kk and project_id=$project_sel_f limit 1")->get();
        if(count($get_categiryname)>0){
          $project_category = $get_categiryname[0]->status_name;
          $project_category = trim($project_category);
          if($p3_status_kk == 2 || $p3_status_kk == 3 || $p3_status_kk == 2570 || $project_category == 'Rank 5' || $project_category == 'Rank 10' || $project_category == 'Rank 11'){
            $blockmail = 1;
            $project_category="{{project_category}}";
          }
        }else{
          $project_category="{{project_category}}";
        }
      }
      if($master_com_id !='' && $master_com_id != 'NULL'){
        $getstates = QB::query("select state from companies where id = $master_com_id")->get();
        if(count($getstates)>0){
        $states =  $getstates[0]->state;
        }else{
          $states="{{state}}";
        }
      }else{
        $states="{{state}}";
      }
      if($states == '' or $states == 'NULL'){
        $states="{{state}}";
      }
      $strMailContent = str_replace("{{state}}", $states, $strMailContent);
      $strMailContent = str_replace("{{country}}", $cntry, $strMailContent);
      $strMailContent = str_replace("{{jobtitles}}", $jobtitles, $strMailContent);

      $coy_status=0;
      $check_coy = QB::query("select count(*) coycnt from coy_category_company where pid=$project_sel_f and cid=$compny_id and coy_flag=1")->get();
      $coy_count = $check_coy[0]->coycnt;
      if($coy_count > 0){
        $coy_status=1;
      }

      $company_category_oty ='Company of the Year';
      if($coy_status == 1){
        $check_coy_mark = QB::query("select coy_flag,date(addeddate) addeddate from company_category_of_year where cid=$compny_id")->get();
        $coy_flag_kk = $check_coy_mark[0]->coy_flag;
        $coy_addeddate = $check_coy_mark[0]->addeddate;
        $get_firstsenddate = QB::query("select date(first_senddate) first_senddate from addperson_detail where cid=$compny_id and email_id = '$receiver_email_id' and  first_senddate is not null and first_senddate!='0000-00-00 00-00'")->get();
        if (count($get_firstsenddate) > 0) {
          $firstsenddate = $get_firstsenddate[0]->first_senddate;
        }
        if($mail_type == 'First Mail' || ($coy_addeddate < $firstsenddate && count($get_firstsenddate) > 0)){
          if($coy_flag_kk == 1 || $coy_flag_kk == 3){
            $company_category_oty = "Company of the Year";
          }elseif($coy_flag_kk == 2 || $coy_flag_kk == 4){
            $company_category_oty = "of the Year";
          }
        }else{
          $company_category_oty = "Company of the Year";
        }
      }

      $in_region_val='';
$region_val='';
      $cost_cover_val='';
      $cost_coy_val='';
      $cost_profille_val='';
      $profile_cost_kk='';
      if ($cntry == 'United States Of America' || $cntry == 'US' || $cntry == 'USA') {
        $cntry = 'United States Of America';
      }
      $check_profile_country= QB::query("select profile_cost from companywise_cost where country = '$cntry'")->get();
      if(count($check_profile_country)>0){
        $profile_cost_kk = $check_profile_country[0]->profile_cost;
      }

      if ((strpos($getmname, "Europe") !== false) || (strpos($getmname, "EUROPE") !== false) || $project_region_status == 3) {
        $check_uk_comp = QB::query("select count(cid) uk_cnt from master_companies where cid=$compny_id and (other_country = 'United Kingdom' or other_country='UK' or country = 'United Kingdom' or country='UK' or country='United Kingdom (UK)' or other_country='United Kingdom (UK)')")->get();
        $uk_count = $check_uk_comp[0]->uk_cnt;
        if($uk_count > 0){
          //$strMailContent = str_replace("europe", "", $strMailContent);
//          $strMailContent = str_replace("Europe", "", $strMailContent);
//          $strMailContent = str_replace("EUROPE", "", $strMailContent);
            $in_region_val='in UK';
$region_val = "UK";
            $cost_cover_val= "9000 GBP";
            $cost_coy_val= "5000 GBP";
            if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk GBP";
          }else{
            $cost_profille_val= "2500 GBP";
          }
        }else{
          $in_region_val='in Europe';
$region_val = "Europe";
          $cost_cover_val= "9000 Euros";
          $cost_coy_val= "5000 Euros";
          if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk Euros";
          }else{
            $cost_profille_val= "3000 Euros";
          }
        }
         
         
         
      } elseif((strpos($getmname, "Apac") !== false) || (strpos($getmname, "APAC") !== false)  || $project_region_status == 2) {
          $in_region_val='in APAC';
$region_val = "APAC";
          $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
        if($profile_cost_kk !=''){
          $cost_profille_val= "$profile_cost_kk USD";
        }else{
          $cost_profille_val= "3000 USD";
        }
      } elseif((strpos($getmname, "Canada") !== false) || (strpos($getmname, "CANADA") !== false)  || ($project_region_status == 1 && $project_region_status2 == 1)) {
          $in_region_val='in Canada';
$region_val = "Canada";
          $cost_cover_val= "15,000 CAD";
          $cost_coy_val= "5000 CAD";
          if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk CAD";
          }else{
            $cost_profille_val= "3000 CAD";
          }
      } elseif((strpos($getmname, "Latin America") !== false) || (strpos($getmname, "LATIN AMERICA") !== false)  || ($project_region_status == 1 && $project_region_status2 == 2)) {
          $in_region_val='in Latin America';
$region_val = "Latin America";
          $cost_cover_val= "$8000";
          $cost_profille_val= "$2000";
          $cost_coy_val= "$5000";
          if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk";
          }else{
            if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk";
          }else{
            $cost_profille_val= "$3000";
          }
          }
      } elseif((strpos($getmname, "MENA") !== false) || (strpos($getmname, "MENA") !== false)) {
        $in_region_val='in MENA';
$region_val = "MENA";
        $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
        if($profile_cost_kk !=''){
          $cost_profille_val= "$profile_cost_kk USD";
        }else{
          $cost_profille_val= "3000 USD";
        }
      }  else{
          $cost_cover_val= "$15,000";
          $cost_coy_val= "$5000";
          $in_region_val='';
$region_val = "";
        if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk";
          }else{
            $cost_profille_val= "$3000";
          }
      }

      $check_uk_comp = QB::query("select count(cid) uk_cnt from master_companies where cid=$compny_id and (other_country = 'United Kingdom' or other_country='UK' or country = 'United Kingdom' or country='UK' or country='United Kingdom (UK)' or other_country='United Kingdom (UK)')")->get();
        $uk_count = $check_uk_comp[0]->uk_cnt;
        if($uk_count > 0){
           //$strMailContent = str_replace("europe", "", $strMailContent);
       // $strMailContent = str_replace("Europe", "", $strMailContent);
       // $strMailContent = str_replace("EUROPE", "", $strMailContent);
       // $strMailContent = str_replace("Mena", "", $strMailContent);
       // $strMailContent = str_replace("mena", "", $strMailContent);
       // $strMailContent = str_replace("MENA", "", $strMailContent);
       // $strMailContent = str_replace("APAC", "", $strMailContent);
        //$strMailContent = str_replace("Apac", "", $strMailContent);
        //$strMailContent = str_replace("apac", "", $strMailContent);
        //$strMailContent = str_replace("Latin America", "", $strMailContent);
       // $strMailContent = str_replace("LATIN AMERICA", "", $strMailContent);
      //  $strMailContent = str_replace("Canada", "", $strMailContent);
      //  $strMailContent = str_replace("CANADA", "", $strMailContent);
            $in_region_val='in UK';
$region_val = "UK";
            $cost_cover_val= "9000 GBP";
            $cost_coy_val= "5000 GBP";
            if($profile_cost_kk !=''){
            $cost_profille_val= "$profile_cost_kk GBP";
          }else{
            $cost_profille_val= "2500 GBP";
          }
        }
      $single_statecountry = QB::query("select * from single_state_or_country_details where cid=$compny_id and status=1")->get();
        if(count($single_statecountry)>0){
          if($project_region_status == 1 && $project_region_status2 == 0){
            $instate_country = "in ".$states;
          }else{
            if($region_val == 'Canada' || $region_val == 'Latin America'){
              $instate_country = "in ".$region_val;
            }
          }
        }else{
          if($project_region_status == 1 && $project_region_status2 == 0){
            $instate_country = "";
          }else{
            if($region_val == 'Canada' || $region_val == 'Latin America'){
              $instate_country = "in ".$region_val;
            }
          }
        }
        
      $getsubscount = QB::query("select subscriber_count from special_child_details where magid=$add_magid order by id desc limit 1")->get();
      if (count($getsubscount)>0){
        $subscriber_count = $getsubscount[0]->subscriber_count;
      }else{
        $subscriber_count="{{subscribercount}}";
      }
      $get_count_compay=QB::query("select coy_flag,left_rec_id,right_rec_id,(select primary_term from company_recognition_terms where id=s.left_rec_id) left_name,(select primary_term from company_recognition_terms where id=s.right_rec_id) right_name from company_category_of_year s where cid=$compny_id limit 1")->get();
      if(count($get_count_compay) > 0){  
        $left_term=$get_count_compay[0]->left_rec_id;
        $right_term=$get_count_compay[0]->right_rec_id;
        $left_name=$get_count_compay[0]->left_name;
        $right_name=$get_count_compay[0]->right_name;
        if($left_term !='' && $left_term !=0){
          if($left_name == '[Blank]'){
            $left_name_value="";
          }else{
            $left_name_value=$left_name." ";
          }
        }else{
          $left_name_value="Top ";
        }
          if($right_term !='' && $right_term !=0){
          if($right_name == '[Blank]'){
            $right_name_value="";
          }else{
            $right_name_value=" ".$right_name;
          }
          }
      }else{
        $left_name_value="Top ";
        $right_name_value="";
      }
      if($right_name == 'Best-in-{{state}}' || $left_name == 'Best-in-{{state}}'){
        $instate_country='';
      }
      
      $check_partner_name = QB::query("select partner_comp from startup_or_partner_details where status=1 and cid=$compny_id and partner_comp is not null and partner_comp !='' and partner_comp!='.' limit 1")->get();
      if(count($check_partner_name) > 0){
        $partner_namek = $check_partner_name[0]->partner_comp;
      }else{
        $partner_namek = '{{partnername}}';
      }
      
      $strMailContent = str_replace("{{partnername}}", $partner_namek, $strMailContent);
      $subject_f = str_replace("{{partnername}}", $partner_namek, $subject_f);
      $strMailContent = str_replace("{{top}}", $left_name_value, $strMailContent);
      $subject_f = str_replace("{{top}}", $left_name_value, $subject_f);
      $strMailContent = str_replace("{{company_of_the_year}}", $right_name_value, $strMailContent);
      $subject_f = str_replace("{{company_of_the_year}}", $right_name_value, $subject_f);
      $strMailContent = str_replace("{{state}}", $states, $strMailContent);
      $strMailContent = str_replace("{{country}}", $cntry, $strMailContent);
      $strMailContent = str_replace("{{in_country_state}}", $instate_country, $strMailContent);
$strMailContent = str_replace("{{first_line}}", $first_word, $strMailContent);
      $category_array = array('Services', 'Solutions', 'Service', 'Solution', 'services', 'service', 'solutions', 'solution'); 
if (in_array($project_category, $category_array)) {
  $project_category ='{{project_category}}';
}
if ($project_category == '') {
  $project_category ='{{project_category}}';
}
      $strMailContent = str_replace("{{project_category}}", $project_category, $strMailContent);
      $strMailContent = str_replace("{{cost_para}}", $cost_word, $strMailContent);
      $strMailContent = str_replace("{{disclaimer}}", $disclaimer_word, $strMailContent);
      $strMailContent = str_replace("{{cost_cover}}", $cost_cover_val, $strMailContent);
      $strMailContent = str_replace("{{cost_COY}}", $cost_coy_val, $strMailContent);
      $strMailContent = str_replace("{{cost_profile}}", $cost_profille_val, $strMailContent);
      $strMailContent = str_replace("{{region}}", $region_val, $strMailContent);
      $strMailContent = str_replace("{{in_region}}", $in_region_val, $strMailContent);
      $strMailContent = str_replace("{{subscribercount}}", $subscriber_count, $strMailContent);
    
    $categorycustomization = "I have some great news for you. Based on the nominations received from our subscribers, our editorial panel has shortlisted {{company}} to be honored as the ‘Top Pioneer Company in {{general_category}} 2024’ in our 8th annual edition on Pharma and Life Sciences. {{company}}'s expertise on {{general_category}} will be showcased to our extensive readership base of 212,000 readers.";
    $strMailContent = str_replace("{{closedcontent1}}",$closed_client_1k,$strMailContent);
        $strMailContent = str_replace("{{old_project_category}}",$old_status_name,$strMailContent);
        $strMailContent = str_replace("{{magazinename}}", $getmname, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
        $strMailContent = str_replace("{{magazinewithlink_new}}", $mnameurl_new, $strMailContent);
    $strMailContent = str_replace("{{categorycustomization}}",$categorycustomization,$strMailContent);
    $strMailContent = str_replace("{{company_of_the_year}}", $company_category_oty, $strMailContent);
    $strMailContent = str_replace("{{general_category}}",$general_cat_name,$strMailContent);
    $strMailContent = str_replace("{{firstname}}",$first_name_kk,$strMailContent);
    $strMailContent = str_replace("{{lastname}}",$last_name_kk,$strMailContent);
    $strMailContent = str_replace("{{ranking_name}}", $show_ranking_name, $strMailContent);
    $strMailContent = str_replace("{{last_line}}", $lastline_word, $strMailContent);
    $strMailContent = str_replace("{{unsubscribe_line}}", $unsubscribe_word, $strMailContent);
    $strMailContent = str_replace("{{sender_fname}}", $sender_fname_k, $strMailContent);
    $strMailContent = str_replace("{{sender_lname}}", $sender_lname_k, $strMailContent);
    $strMailContent = str_replace("{{newmagazine}}", $getmname, $strMailContent);
    $strMailContent = str_replace("{{newproject}}", $getpname2, $strMailContent);
    $strMailContent = str_replace("{{newprojectwithyear}}", $getpname, $strMailContent);
    $strMailContent = str_replace("{{name}}", $receiver_name, $strMailContent);
    $strMailContent = str_replace("{{lname}}", $lname, $strMailContent);
    $strMailContent = str_replace("{{person_id}}", $add_person_id, $strMailContent);
    $strMailContent = str_replace("{{receiver_id}}", $unique_id, $strMailContent);
    $strMailContent = str_replace("{{company}}", $company_name, $strMailContent);
    $strMailContent = str_replace("{{designation}}", $designation_email_f, $strMailContent);
    $strMailContent = str_replace("{{email}}", $unique_id, $strMailContent);
    $strMailContent = str_replace("{{sender_name}}", $this->sender_name, $strMailContent);
    $strMailContent = str_replace("{{field5}}", $field5, $strMailContent);
    $strMailContent = str_replace("{{field6}}", $field6, $strMailContent);
    $strMailContent = str_replace("{{closedcontent}}", '', $strMailContent);
    $strMailContent = str_replace("{{signature}}", $signature_new, $strMailContent);
    $strMailContent = str_replace("{{signature_swap}}", $signature_new, $strMailContent);
    $strMailContent = str_replace("{{aboutMagazine}}", $aboutMagazine, $strMailContent);
    $strMailContent = str_replace("{{oldmagazine}}", $oldmagazine, $strMailContent);
    $strMailContent = str_replace("{{oldproject}}", $oldproject, $strMailContent);
    $return_val = '';

    $check_emails = QB::query("select project_email from project_wise_sender_emails where pid= $project_sel_f ")->get();
      if(count($check_emails)>0){
        $sign_pid = $check_emails[0]->project_email;
      }else{
        $sign_pid = $project_sel_f;
      }
      $kk_signature = QB::query("select signature from sender_email where  magid=$add_magid and email = '$sender_email' and signature !='' and signature != 'NULL' and signature is not null  and activate =0")->get();
      if (count($kk_signature) == 0) {
        $kk_signature = QB::query("select signature from sender_email where magid=$add_magid and email = '$sender_email' and signature !='' and signature != 'NULL' and signature is not null and activate =0 ")->get();
      }

      if($strMailContent == '' || $strMailContent == 'NULL'){
        $return_val = "content_empty";
        return $return_val;
      }
              if(count($kk_signature)>0){
                $domainsender=explode("@",$sender_email);
                $firstname =$domainsender[0];
                $firstname1=explode(".",$firstname);
                $signname =$firstname1[0];
                $signlastname =$firstname1[1];
                $lowercontend=strtolower($strMailContent);               
                $lowersign=strtolower($signname);               
                $lowerlastsign=strtolower($signlastname);               
                if((strpos($lowercontend,$lowersign) !== false) && (strpos($lowercontend,$lowerlastsign) !== false)){
                  $return = "matched_signature";
                }else{
                  $return_val = "not_match_signature";
                  return $return_val;
                }


              }else{
                $domainsender=explode("@",$sender_email);
                $firstname =$domainsender[0];
                $firstname1=explode(".",$firstname);
 
                if (count($firstname1) == 2)
                 {
                   $signname =substr($firstname1[0],0,-1); 
                   $signlastname =$firstname1[1]; 
                 }else{
                   $signname =$firstname1[0]; 
                   $signlastname =$firstname1[2]; 
                 }
                 $lowercontend=strtolower($strMailContent);               
                 $lowersign=strtolower($signname); 
                 $lowerlastsign=strtolower($signlastname);               
                 if((strpos($lowercontend,$lowersign) !== false) && (strpos($lowercontend,$lowerlastsign) !== false)){                
                    $return = "matched_signature";
                 }else{
                   $return_val = "not_match_signature";
                   return $return_val;
                 }
              }
    unset($field7);
    unset($exception);
    unset($bulk);

    $strMailContent = str_replace("{{category}}", $cmp_status, $strMailContent);
    $strMailContent = str_replace("{{person_id_track}}", $add_person_id, $strMailContent);
    $strMailContent = str_replace("{{compose_id_track}}", $unique_id, $strMailContent);
    $receiver_email_idd = self::encrypt_decrypt('encrypt', $receiver_email_id);
    $receiver_unsubscribe = self::encrypt_decrypt('encrypt', $receiver_emaill);
    $sender_unsubscribe = self::encrypt_decrypt('encrypt', $sender_email);
    $project_idd = self::encrypt_decrypt('encrypt', $project_sel_f);
    $person_track_spark =  $add_person_id;
    $compose_track_spark = $unique_id;
    $pname = self::get_project($project_sel_f);
    $sub_domain = str_replace(' ', '-', $pname);
    $person_track_spark1 =  self::encrypt_decrypt('encrypt', $add_person_id);
    $compose_track_spark1 = self::encrypt_decrypt('encrypt', $unique_id);
$strMailContent = str_replace("unsubscribe", "notifyus", $strMailContent);
    $array_counts_ns = array();
    $word1 = "notifyus";
    $word2 = "optout";
    $word3 = "letusknow";
    $word4 = "unsubscribe";
    $word5 = "donotsend";
    $word6 = "informus";
    $word7 = "tellus";
    $word8 = "unjoin";

    if (strpos($strMailContent, $word1) !== false) {
      array_push($array_counts_ns, $word1);
    }
    if (strpos($strMailContent, $word2) !== false) {
      array_push($array_counts_ns, $word2);
    }
    if (strpos($strMailContent, $word3) !== false) {
      array_push($array_counts_ns, $word3);
    }
    if (strpos($strMailContent, $word4) !== false) {
      array_push($array_counts_ns, $word4);
    }
    if (strpos($strMailContent, $word5) !== false) {
      array_push($array_counts_ns, $word5);
    }
    if (strpos($strMailContent, $word6) !== false) {
      array_push($array_counts_ns, $word6);
    }
    if (strpos($strMailContent, $word7) !== false) {
      array_push($array_counts_ns, $word7);
    }
    if (strpos($strMailContent, $word8) !== false) {
      array_push($array_counts_ns, $word8);
    }

    foreach ($array_counts_ns as $rep_with_word4) {
      if ($rep_with_word4 == 'donotsend') {
        $unsubscribeLinkURL = self::getUnsubscribeLink_new_one($magid, $sender_domain, $sub_domain, $rep_with_word4,$this->signval_new);
      } else {
        $unsubscribeLinkURL = self::getUnsubscribeLink_new($magid, $sender_domain, $sub_domain, $rep_with_word4,$this->signval_new);
      }

      $unsubscribeLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_idd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{project_idd}}", $project_idd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{sender_email}}", $sender_unsubscribe, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{mail_type}}", $mail_type, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_unsubscribe, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{project_iddd}}", $pidd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{unsub_word}}", $rep_with_word4, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("amp;", '', $unsubscribeLinkURL);
      $strMailContent = str_replace($rep_with_word4, $unsubscribeLinkURL, $strMailContent);
    }

    $unsubscribeLinkOTurl='';
    
    $unsubscribeLinkOTurl = self::getUnsubscribeLink_kajolnew($magid, $sender_domain, $sub_domain, '', $this->signval_new);

      if($unsubscribeLinkOTurl == ''){
        $unsubscribeLinkOTurl = "{{unsub_OT}}";
      }

      $unsubscribeLinkOTurl = str_replace("{{receiver_email_idd}}", $receiver_email_idd, $unsubscribeLinkOTurl);
      $unsubscribeLinkOTurl = str_replace("{{project_idd}}", $project_idd, $unsubscribeLinkOTurl);
      $unsubscribeLinkOTurl = str_replace("{{person_track_spark}}", $person_track_spark, $unsubscribeLinkOTurl);
      $unsubscribeLinkOTurl = str_replace("{{compose_track_spark}}", $compose_track_spark, $unsubscribeLinkOTurl);

      $unsubscribeLinkOTurl = str_replace("{{sender_email}}", $sender_unsubscribe, $unsubscribeLinkOTurl);
      $unsubscribeLinkOTurl = str_replace("{{mail_type}}", $mail_type, $unsubscribeLinkOTurl);

      $unsubscribeLinkOTurl = str_replace("{{receiver_email_iddd}}", $receiver_unsubscribe, $unsubscribeLinkOTurl);

      $unsubscribeLinkOTurl = str_replace("{{project_iddd}}", $pidd, $unsubscribeLinkOTurl);
      $unsubscribeLinkOTurl = str_replace("{{unsub_word}}", "Unsubscribe", $unsubscribeLinkOTurl);
      $strMailContent = str_replace("{{unsub_OT}}", $unsubscribeLinkOTurl, $strMailContent);

    $rep_with_wordp = '';
    $spamlinkLinkURL = self::getUnsubscribeLink_new($magid, $sender_domain, $sub_domain, $rep_with_wordp,$this->signval_new, 0, 1);
    $spamlinkLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_idd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_unsubscribe, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_idd}}", $project_idd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_iddd}}", $pidd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{sender_email}}", $sender_unsubscribe, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{mail_type}}", $mail_type, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("amp;", '', $spamlinkLinkURL);
    $strMailContent = str_replace("{{spamlink}}", $spamlinkLinkURL, $strMailContent);
    $strMailTextVersion = $strMailContent;
    $strRawMessage = "";
    $boundary = uniqid(rand(), true);
    $boundarya = uniqid(rand(), true);
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = $receiver_name;
    $strToMail = $receiver_email_id;
    $strSesFromName = $this->sender_name;
    $strSesFromEmail = $this->sender_email;

    $strSubject = $subject_f;
    $strSubject = str_replace("{{in_country_state}}", $instate_country, $strSubject);
      $strSubject = str_replace("{{state}}", $states, $strSubject);
      $strSubject = str_replace("{{country}}", $cntry, $strSubject);
      $strSubject = str_replace("{{region}}", $region_val, $strSubject);
$strSubject = str_replace("{{name}}", $receiver_name, $strSubject);
    $strSubject = str_replace("{{lname}}", $lname, $strSubject);
    $strSubject = str_replace("{{company}}", $company_name, $strSubject);
    $strSubject = str_replace("{{designation}}", $designation_email_f, $strSubject);
    $strSubject = str_replace("{{newmagazine}}", $getmname, $strSubject);
    $strSubject = str_replace("{{newproject}}", $getpname2, $strSubject);
    $strSubject = str_replace("{{newprojectwithyear}}", $getpname, $strSubject);
    $strSubject = str_replace("{{aboutMagazine}}", $aboutMagazine, $strSubject);
    $strSubject = str_replace("{{oldmagazine}}", $oldmagazine, $strSubject);
    $strSubject = str_replace("{{oldproject}}", $oldproject, $strSubject);
      $strSubject = str_replace("{{general_category}}",$general_cat_name,$strSubject);
    $strSubject = str_replace("{{ranking_name}}",$show_ranking_name,$strSubject);
      $strSubject = str_replace("{{country}}", $cntry, $strSubject);
      $strSubject = str_replace("{{region}}", $region_val, $strSubject);
      $strSubject = str_replace("{{state}}", $states, $strSubject);
$strSubject = str_replace("{{category}}", $cmp_status, $strSubject);
$category_array = array('Services', 'Solutions', 'Service', 'Solution', 'services', 'service', 'solutions', 'solution'); 
if (in_array($project_category, $category_array)) {
  $project_category ='{{project_category}}';
}
if ($project_category == '') {
  $project_category ='{{project_category}}';
}
      $strSubject = str_replace("{{project_category}}", $project_category, $strSubject);
    $strSubject = str_replace("{{company_of_the_year}}", $company_category_oty, $strSubject);
    $strMailTextVersion = str_replace("(CXO)",'', $strMailTextVersion);
    $strMailTextVersion = str_replace("(cxo)",'', $strMailTextVersion);

    if (trim($strSubject) == '' || trim($strMailTextVersion) == '') {
      $blockmail = 1;
      $return_val = "subject_message_is_empty";
    }
     
    if (strlen($strMailTextVersion) < 200) {
      $blockmail = 1;
      $return_val = "mail_content_lessthen_200";
    }
    $check_ranking_name_mail = strpos($strMailTextVersion, "{{ranking_name}}");
    if ($check_ranking_name_mail !== false) {
      $blockmail = 1;
      $return_val = "ranking_name_not_replaced";
return $return_val;
    }
    $check_ranking_name_sub = strpos($strSubject, "{{ranking_name}}");
    if ($check_ranking_name_sub !== false) {
      $blockmail = 1;
      $return_val = "ranking_name_not_replaced";
return $return_val;
    }else{
      // $subject_word_count = str_word_count($strSubject);
      // if ($subject_word_count < 5) {
      //   $blockmail = 1;
      //   $return_val = "subject_line_is_less_than_five_words";
      // }
    }
   
    $check_variable_msg1 = preg_match("/}}/i", $strMailTextVersion);
      $check_variable_msg2 = preg_match("/}/i", $strMailTextVersion);
      $check_variable_msg3 = preg_match("/{/i", $strMailTextVersion);
      $check_variable_msg = preg_match("/{{/i", $strMailTextVersion);
      $check_variable_sub = preg_match("/{{/i", $strSubject);
      $check_variable_sub1 = preg_match("/}}/i", $strSubject);
      $check_variable_sub2 = preg_match("/}/i", $strSubject);
      $check_variable_sub3 = preg_match("/{/i", $strSubject);
      $strMailTextVersion11= addslashes($strMailTextVersion);
    if ($check_variable_sub > 0 || $check_variable_sub1 > 0 || $check_variable_sub2 > 0 || $check_variable_sub3 > 0) {
      $blockmail = 1;
      $variable_track = QB::query("insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubject','$strMailTextVersion11',$unique_id,1,now())");
        $return_val = "variable_not_replaced";
      return $return_val;
    }

    if ($check_variable_msg > 0 || $check_variable_msg1 > 0 || $check_variable_msg2 > 0 || $check_variable_msg3 > 0) {
      $blockmail = 1;
      $variable_track = QB::query("insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubject','$strMailTextVersion11',$unique_id,1,now())");
        $return_val = "variable_not_replaced";
      return $return_val;
    }
    if ($blockmail == 0) {
      $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
      $strRawMessage .= 'To: ' . self::encodeRecipients($strToMailName . " <" . $strToMail . ">") . "\r\n";
      $strRawMessage .= 'From: ' . self::encodeRecipients($strSesFromName . " <" . $strSesFromEmail . ">") . "\r\n";
      $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
      $strRawMessage .= 'Content-type: Multipart/mixed; boundary=' . $boundary . "\r\n";
      $strRawMessage .= "\r\n--{$boundary}\r\n";
      $strRawMessage .= 'Content-type: Multipart/alternative; boundary=' . $boundarya . "\r\n";
      $strRawMessage .= "\r\n--{$boundarya}\r\n";
      $strRawMessage .= 'Content-Type: text/plain; charset=' . $charset . "\r\n";
      $strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
      $strRawMessage .= strip_tags($strMailTextVersion) . "\r\n";
      $strRawMessage .= "\r\n--{$boundarya}\r\n";
      $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
      $strRawMessage .= "\n\n" . $strMailTextVersion . "\r\n";
      $strRawMessage .= "\r\n--{$boundarya}--\r\n";
      $strRawMessage .= "\r\n--{$boundary}\r\n";
      $strRawMessage .= '--' . $boundary . "--\r\n";
      $return_val = "";

      if ($seg_type == 2) {
        $sender1 = explode("@", $strSesFromEmail);
        $firstname = $sender1[0];
        $firstname1 = explode(".", $firstname);

        if (count($firstname1) == 2) {
          $signname = substr($firstname1[0], 0, -1);
        } else {
          $signname = $firstname1[0];
        }

        $strMailContent = addslashes($strMailContent);

        $insert = QB::query("insert into outlook_draft_details(session_id,receiver_email,sender_email,receiver_name,sender_name,mail_content,subject,mail_type,addeddate)
                  values('$session_id','$strToMail','$strSesFromEmail','$strToMailName','$signname'," . "\"" . $strMailContent . "\",\"" . $strSubject . "\",'$mail_type',now())");

        if ($insert) {
          $return_val = "drafted";
        } else {
          $return_val = "error_mail_sending";
        }
      } else {

          try {
            $drafts = $client_g->users_drafts->listUsersDrafts('me');
            $draftsList = $drafts->getDrafts();
            $draftCount_prev = count($draftsList);
            
            $messagesContent = self::createGmailAPIMessage($strRawMessage);
            $draftEmail = self::createGmailAPIDraft($client_g, 'me', $messagesContent);
            
            if ($draftEmail->getId()) {
                $drafts1 = $client_g->users_drafts->listUsersDrafts('me');
                $draftsList1 = $drafts1->getDrafts();
                $newDraftId = null;

                $existingDraftIds = array();
                foreach ($draftsList as $d) {
                    $existingDraftIds[] = $d->getId();
                }
            
                foreach ($draftsList1 as $draft) {
                    if (!in_array($draft->getId(), $existingDraftIds)) {
                        $newDraftId = $draft->getId();
                        break;
                    }
                }
            
                if ($newDraftId !== null) {
                    $labelId = self::getOrCreateLabelId($client_g, 'Real Mails');
            
                    if ($labelId) {
                        $draftDetails = $client_g->users_drafts->get('me', $newDraftId);
                        $message = $draftDetails->getMessage();
                        $msgId = $message->getId();
            
                        $mods = new Google_Service_Gmail_ModifyMessageRequest();
                        $mods->setAddLabelIds(array($labelId));
                        $client_g->users_messages->modify('me', $msgId, $mods);
                    }
            
                    $return_val = "drafted";
                } else {
                    $return_val = "error_mail_sending";
                }
            } else {
                $return_val = "error_mail_sending";
            }
          } catch (Exception $e) {
          $today = date('Y-m-d');
          $error_msg2 = addslashes($e->getMessage());
          $sql_comp = "insert into email_exception_error_logs(sender_email,receiver_email,error_message,status,date_time) values(:sender_email,:receiver_email,:error_message,:status,now())";
          $conn = QB::pdo();
          $query_comp = $conn->prepare($sql_comp);
          $query_comp->execute(array(
            ':sender_email' => $this->sender_email,
            ':receiver_email' => $receiver_email_id,
            ':error_message' => $error_msg2,
            ':status' => 151
          ));
          $return_val = "something_went_wrong";
        }
      }
    }
    return $return_val;
  }

?>





