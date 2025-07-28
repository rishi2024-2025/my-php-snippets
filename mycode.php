<?php

public function draftEmailGmailAPI_prahar($receiver_email_id, $receiver_name, $company_name, $designation_email_f, $project_sel_f, $magid, $compny_id, $mail_type, $sender_email, $subject_f, $mail_content, $unique_id, $add_person_id, $client_g, $field5, $field6, $field7, $cmp_status, $draft_name, $sender_domain, $lname = null, $signature = null, $signature_swap = null)
  {
    if ($lname != null && $lname != '') {
      $lname = $lname;
    }

    $strMailContent = "$mail_content";
    $caseStudyContent = $caseStudyContent2 = "";

    if (($magid == 1 || $magid == 49) && strpos($strMailContent, "{{casestudypara1}}") !== false && $draft_name == 'Past Client' && $project_sel_f != 3092 && $project_sel_f != 2577) {

      $strMailContent = str_replace("{{casestudypara1}}", $caseStudyContent, $strMailContent);
      $strMailContent = str_replace("{{casestudypara2}}", $caseStudyContent2, $strMailContent);
    } else {
      $strMailContent = str_replace("{{casestudypara1}}", "", $strMailContent);
      $strMailContent = str_replace("{{casestudypara2}}", "", $strMailContent);
    }

    $info_content =  "";
      $strMailContent = str_replace("{{info}}", $info_content, $strMailContent);

    $strMailContent = str_replace("{{casestudypara1}}", "", $strMailContent);
    $strMailContent = str_replace("{{casestudypara2}}", "", $strMailContent);
    $batchh = self::getBatch($compny_id);

    $bulk_exception = self::getExceptionBulk($compny_id);
      $bulk = $bulk_exception[bulk];
      $exception = $bulk_exception[exception];
      if (($batchh == 'BClient') || (($exception == 2) && ($bulk != 2000 && $bulk != 5000))) {
        $field7 = "<br><br>" . $field7;
      }

    $receiver_emaill =  $receiver_email_id;
    $pidd = $project_sel_f;

//     echo "\n -------- " . "select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid) magid from master_companies m where cid = $compny_id ";
    $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid limit 1) magid from master_companies m where cid = $compny_id ")->get();
//     echo "\n   <<<<<<<<<<<<<<<<<<<< ";
    $magid = $comp_details[0]->magid;
      if ($magid == '' || $magid == 'NULL' || $magid == 0) {
      echo "\n  ========== "."select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ";
      $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ")->get();
    }

    $status_name = $comp_details[0]->status_name;
    $magid = $comp_details[0]->magid;
    $add_curl = $comp_details[0]->curl;

    $get_year = QB::query("select year from projectinfo where pid=$pidd")->get();
    $year_k = $get_year[0]->year;

    $pname_array = self::get_project($pidd);
    $remove_year = explode($year_k, $pname_array);
    $rem_pname = $remove_year[0];
    $magid_cond='';
    if ($magid != '' && $magid != 'NULL' && $magid != 0) {
      $magid_cond = " and magid = $magid";
    }
    // echo "\n  ========== "."select f_name,l_name,subscriber_count,phone_no,magid,phy_address,old_new_sign from special_child_details where child_email_id = '$this->sender_email' $magid_cond limit 1";
    $getflname = QB::query("select f_name,l_name,subscriber_count,phone_no,magid,phy_address,old_new_sign from special_child_details where child_email_id = '$this->sender_email' $magid_cond limit 1")->get();
   
    $shof_name = $getflname[0]->f_name;
    $shol_name = $getflname[0]->l_name;
    $old_new_sign = $getflname[0]->old_new_sign;
    $subscriber_count = $getflname[0]->subscriber_count;
    $shophone_no = $getflname[0]->phone_no;
    $phy_address = $getflname[0]->phy_address;
    $magid_kk = $magid;
    if ($magid_kk != '' && $magid_kk != 'NULL' && $magid_kk != 0) {
     
      $outlook_draft = QB::query("select * from master_companies where  cid=$compny_id and extra_field2='1'")->get();
      if(count($outlook_draft) == 0){
        $outlook_kaj_flag =0;
      }else{
        $outlook_kaj_flag =1;
      }
    }

    $shomagazine = self::get_magazine($magid);
    // echo "\n  select magazine_url,mag_description from magazine_details where magid = $magid ";
    $get_magurl = QB::query("select magazine_url,mag_description from magazine_details where magid = $magid")->get();
    $show_magurl = $get_magurl[0]->magazine_url;
    $mnameurl = "<a href='http://www." . $show_magurl . "' target='_blank'>" . $shomagazine . "</a>";
    $magazinekk_url = $show_magurl;

    $aboutMagazine = $get_magurl[0]->mag_description;
    if ($aboutMagazine == '') {
      $aboutMagazine = "{{aboutMagazine}}";
    }
    // echo "\n  ddddddddddddddd ";
    
    if ($status_name == 'Rank 11') {
      echo "\n  ========== "."select pid, cid, cname from master_companies where curl = '$add_curl' and status=1 order by cid desc limit 1";
      $select_oldpid = QB::query("select pid, cid, cname from master_companies where curl = '$add_curl' and status=1 order by cid desc limit 1")->get();
      if (count($select_oldpid) > 0) {
        $get_oldpid = $select_oldpid[0]->pid;
        $oldproject = self::get_project($get_oldpid);
        $oldmagazine = self::get_magazine(self::magazine_id($get_oldpid));

        $check_mag = QB::query("select magid,pname,year from projectinfo where pid=$get_oldpid")->get();
        $old_mag = $check_mag[0]->magid;
        $oldprojectk = $check_mag[0]->pname;
            $old_year = $check_mag[0]->year;
            $oldprojectkk = explode($old_year, $oldprojectk);
            $oldproject = $oldprojectkk[0];
        $oldmagazine = self::get_magazine($old_mag);

        $get_oldmagurl = QB::query("select magazine_url from magazine_details where magid = $old_mag")->get();
        $show_oldmagurl = $get_oldmagurl[0]->magazine_url;
        $oldmnameurl = "<a href='http://www." . $show_oldmagurl . "' target='_blank'>" . $oldmagazine . "</a>";
      } else {
        $oldproject = "{{oldproject}}";
        $oldmagazine = "{{oldmagazine}}";
        $oldmnameurl = "{{oldmagazinewithlink}}";
      }
    } else {

      $select_oldpid = QB::query("select (select pid from collection.client_details where client_id=mi.cid limit 1) as Proj from master_companies_info mi where master_id=$compny_id")->get();

      if (count($select_oldpid) > 0) {
        $get_oldpid = $select_oldpid[0]->Proj;

        $check_mag = QB::query("select magid,pname,year from projectinfo where pid=$get_oldpid")->get();
        $old_mag = $check_mag[0]->magid;
        $oldprojectk = $check_mag[0]->pname;
            $old_year = $check_mag[0]->year;
            $oldprojectkk = explode($old_year, $oldprojectk);
            $oldproject = $oldprojectkk[0];
        $oldmagazine = self::get_magazine($old_mag);

        $get_oldmagurl = QB::query("select magazine_url from magazine_details where magid = $old_mag")->get();
        $show_oldmagurl = $get_oldmagurl[0]->magazine_url;
        $oldmnameurl = "<a href='http://www." . $show_oldmagurl . "' target='_blank'>" . $oldmagazine . "</a>";
      } else {
        $select_oldpid_agin = QB::query("select curl from master_companies where cid=$compny_id")->get();
        $curl =  $select_oldpid_agin[0]->curl;
        $fetch_old_pid = QB::query("select pid from master_companies where curl = '$curl' and status=1 order by cid desc")->get();
        if (count($fetch_old_pid) > 0) {
          $fetch_old = $fetch_old_pid[0]->pid;
          $check_mag = QB::query("select magid,pname,year from projectinfo where pid=$fetch_old")->get();
          $old_mag = $check_mag[0]->magid;
          $oldprojectk = $check_mag[0]->pname;
            $old_year = $check_mag[0]->year;
            $oldprojectkk = explode($old_year, $oldprojectk);
            $oldproject = $oldprojectkk[0];
          $oldmagazine = self::get_magazine($old_mag);
          $get_oldmagurl = QB::query("select magazine_url from magazine_details where magid = $old_mag")->get();
          $show_oldmagurl = $get_oldmagurl[0]->magazine_url;
          $oldmnameurl = "<a href='http://www." . $show_oldmagurl . "' target='_blank'>" . $oldmagazine . "</a>";
        } else {
          $oldproject = "{{oldproject}}";
          $oldmagazine = "{{oldmagazine}}";
          $oldmnameurl = "{{oldmagazinewithlink}}";
        }
      }
    }

      if ($compny_id != '') {

        $project_details = QB::query("select status,print_online_hold_status from projectinfo where pid=$pidd")->get();
        $status_k = $project_details[0]->status;
        $print_online_hold_status_k = $project_details[0]->print_online_hold_status;

        if ($oldmagazine != $shomagazine) {
          $differentoldmagazine_val = "which belongs to the same organization that owns {{oldmagazine}}.";
          $strMailContent = str_replace("{{differentoldmagazine}}", $differentoldmagazine_val, $strMailContent);
        } else {
          $strMailContent = str_replace("{{differentoldmagazine}}", '', $strMailContent);
        }
        // echo "\n  fffffffffffffffffffffffffff ";
        $check_rankkk = QB::query("select `rank`,curl from master_companies where cid = $compny_id and `rank` in (5,10,11)")->get();
        if (count($check_rankkk) > 0) {
          $check_rankkk_curl = $check_rankkk[0]->curl;
          $check_rankkk_rank = $check_rankkk[0]->rank;

          $fetch_htmllink = QB::query("select cid from master_companies where curl = '$check_rankkk_curl' and status=1 order by cid desc limit 1")->get();
          if (count($fetch_htmllink) > 0) {
            $fetch_old_cid = $fetch_htmllink[0]->cid;
            $get_html_link = QB::query("select new_website_link from cwf.cwf_sold_companies where compayny_id=$fetch_old_cid ")->get();
            $old_new_website_link = $get_html_link[0]->new_website_link;
          }
          $closed_client_1k = "I am excited to let you know that {{company}}’s cover feature has been receiving a great response from our readers. In the past 30 days alone, {{company}}’s cover profile has received about {{traffic_view}} page views and {{traffic_click}} clicks from visitors who were highly intrigued by {{company}}’s expertise and compelled to explore more; ultimately, lead to visit your website from {{magazinewithlink}}.";

          $closed_client_3k = "I am excited to let you know that {{company}}’s feature as the ‘Editor’s Choice’ has been receiving a great response from our readers. In the past 30 days alone, {{company}}’s profile page has received about {{traffic_view}} page views and {{traffic_click}} clicks from visitors who were highly intrigued by {{company}}’s expertise and compelled to explore more; ultimately, lead to visit your website from {{magazinewithlink}}.";

          $closed_client_2k = "I am excited to let you know that {{company}}’s ‘Company of the Year’ feature has been receiving a great response from our readers. In the past 30 days alone, {{company}}’s profile page has received about {{traffic_view}} page views and {{traffic_click}} clicks from visitors who were highly intrigued by {{company}}’s expertise and compelled to explore more; ultimately, lead to visit your website from {{magazinewithlink}}.";

          if ($status_k == 0 && $print_online_hold_status_k == 0 && ($check_rankkk_rank == 5 || $check_rankkk_rank == 10 || $check_rankkk_rank == 11)) {
            $strMailContent = str_replace("{{closedcontent4}}", '', $strMailContent);
            $strMailContent = str_replace("{{closedcontent5}}", '', $strMailContent);
            $strMailContent = str_replace("{{closedcontent6}}", '', $strMailContent);
            $strMailContent = str_replace("{{oldmagazinewithlink}}", $oldmnameurl, $strMailContent);
            $strMailContent = str_replace("{{companypreviousprofile}}", $old_new_website_link, $strMailContent);
          } else {

            $strMailContent = str_replace("{{closedcontent4}}", $closed_client_1k, $strMailContent);
            $strMailContent = str_replace("{{closedcontent5}}", $closed_client_2k, $strMailContent);
            $strMailContent = str_replace("{{closedcontent6}}", $closed_client_3k, $strMailContent);
            $strMailContent = str_replace("{{magazinename}}", $shomagazine, $strMailContent);
            $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
            $strMailContent= str_replace("{{magazineurl}}", $magazinekk_url, $strMailContent);
            $strMailContent = str_replace("{{oldmagazinewithlink}}", $oldmnameurl, $strMailContent);
            $strMailContent = str_replace("{{companypreviousprofile}}", $old_new_website_link, $strMailContent);

            $check_p1_kj = QB::query("select count(*) p1_cnt from addperson_detail where cid=$compny_id and email_id = '$receiver_email_id' and person_type = 'P1'")->get();
            $p1_counts= $check_p1_kj[0]->p1_cnt;
            if (($check_rankkk_rank == 5 || $check_rankkk_rank == 10 || $check_rankkk_rank == 11) && $magidcount == 0  && $listcount == 0) {

            if ($mail_type == 'First Mail' && $p1_counts > 0) {
                $check_traffic = QB::query("select ttl_click,ttl_view from traffic_click_view_rank_details where url ='$check_rankkk_curl' order by date(addeddate) desc,ttl_click desc limit 1")->get();
                if (count($check_traffic) > 0) {
                  $get_traffic_click = $check_traffic[0]->ttl_click;
                  $get_traffic_view = $check_traffic[0]->ttl_view;

                  if ($get_traffic_click >= 60) {
                    $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                    $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
                  } 
                } 
              } else {

                $check_firstmail_date = QB::query("select date(send_date) send_date from d3_compose where cid=$compny_id and mail_type = 'First Mail' and send_status=1")->get();
                if (count($check_firstmail_date) == 0) {
                  $check_firstmail_date = QB::query("select date(send_date) send_date from past_closures_mailing where cid=$compny_id and  mail_type = 'First Mail' and send_status=28 limit 1")->get();
                }
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
                      $check_traffic_fm = QB::query("select ttl_click,ttl_view from traffic_click_view_rank_details where date(addeddate) >= '$firstmail_sent_date' and url ='$check_rankkk_curl' order by date(addeddate) desc,ttl_click desc limit 1")->get();
                        $get_traffic_click = $check_traffic_fm[0]->ttl_click;
                        $get_traffic_view = $check_traffic_fm[0]->ttl_view;
                        if ($get_traffic_click >= 60) {
                          $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                          $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
                        }
                    }
                  } 
                }
              }
            }
          }
        }
      }

    $check_unsubscribe_line = strpos($strMailContent, "{{unsubscribe_line}}");
      if ($check_unsubscribe_line !== false) {
        if ($mail_type == 'First Mail') {
  
          $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
          if (count($get_unsubscribeline) > 0) {
            $unsubscribe_word = $get_unsubscribeline[0]->content_line;
          } else {
            $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_unsubscribeline) > 0) {
              $unsubscribe_word = $get_unsubscribeline[0]->content_line;
            }
          }
        
        }else {
            $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=1 and moving_limit<20) ORDER BY RAND() LIMIT 1")->get();
            if (count($get_unsubscribeline) > 0) {
              $unsubscribe_word = $get_unsubscribeline[0]->content_line;
            } else {
              $get_unsubscribeline = QB::query("select content_line,id,moving_limit from proposal_sub_unsubs_lastline_details where active_status!=2 and  filter = 4 and (flag=0 and moving_limit=0) ORDER BY RAND() LIMIT 1")->get();
              if (count($get_unsubscribeline) > 0) {
                $unsubscribe_word = $get_unsubscribeline[0]->content_line;
              }
            }
        }
      }
      if($unsubscribe_word == ''){
        $unsubscribe_word ='{{unsubscribe_line}}';
      }
      if($outlook_kaj_flag == 1){
        $unsubscribe_word ="Not relevant Sorry, reply 'no thanks' and we'll unsub you.";
      }
      $strMailContent = str_replace("{{unsubscribe_line}}", $unsubscribe_word, $strMailContent);
    $check_comp_country = QB::query("select country,master_com_id from master_companies where cid = $compny_id limit 1")->get();
    $cntry = $check_comp_country[0]->country;
    $master_com_id = $check_comp_country[0]->master_com_id;
    $strMailContent = str_replace("{{magazinename}}", $shomagazine, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
    $strMailContent= str_replace("{{magazineurl}}", $magazinekk_url, $strMailContent);
    $region_val='';
    $region_val_europe='';
    $cost_cover_val='';
    $cost_coy_val='';
    if ((strpos($shomagazine, "Europe") !== false) || strpos($shomagazine, "EUROPE") !== false) {
      $check_uk_comp = QB::query("select count(cid) uk_cnt from master_companies where cid=$compny_id and (other_country = 'United Kingdom' or other_country='UK' or country = 'United Kingdom' or country='UK' or country='United Kingdom (UK)' or other_country='United Kingdom (UK)')")->get();
      $uk_count = $check_uk_comp[0]->uk_cnt;
      if($uk_count > 0){
 
      }else{
        $check_region_var = preg_match("/{{region}}/i", $strMailContent);
        if ($check_region_var == 0) {
          $strMailContent = str_replace("2024", "in Europe 2024", $strMailContent);
          $region_val = "Europe";
        $cost_cover_val= "9000 Euros";
        $cost_coy_val= "5000 Euros";
        }else{
          $region_val = "Europe";
        $cost_cover_val= "9000 Euros";
        $cost_coy_val= "5000 Euros";
        }
      }
    } elseif((strpos($shomagazine, "Apac") !== false) || (strpos($shomagazine, "APAC") !== false)) {
      $check_region_var = preg_match("/{{region}}/i", $strMailContent);
      if ($check_region_var == 0) {
        if ($cntry == 'Australia' || $cntry == 'New Zealand') {
          $region_val = "APAC";
          $strMailContent = str_replace("2024", "in Apac 2024", $strMailContent);
        }else{
          $region_val = "Asia";
          $strMailContent = str_replace("2024", "in Asia 2024", $strMailContent);
        }
          $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
      }else{
        if ($cntry == 'Australia' || $cntry == 'New Zealand') {
          $region_val = "APAC";
        }else{
          $region_val = "Asia";
        }
          $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
      }
    } elseif((strpos($shomagazine, "Canada") !== false) || (strpos($shomagazine, "CANADA") !== false)) {
      $check_region_var = preg_match("/{{region}}/i", $strMailContent);
      if ($check_region_var == 0) {
        $strMailContent = str_replace("2024", "in Canada 2024", $strMailContent);
        $region_val = "Canada";
          $cost_cover_val= "15,000 CAD";
          $cost_coy_val= "7000 CAD";
      }else{
        $region_val = "Canada";
          $cost_cover_val= "15,000 CAD";
          $cost_coy_val= "7000 CAD";
      }
    } elseif((strpos($shomagazine, "Latin America") !== false) || (strpos($shomagazine, "LATIN AMERICA") !== false)) {
      $check_region_var = preg_match("/{{region}}/i", $strMailContent);
      if ($check_region_var == 0) {
        $strMailContent = str_replace("2024", "in Latin America 2024", $strMailContent);
        $cost_cover_val= "$8000";
        $cost_coy_val= "$3000";
        $region_val = "Latin America";
      }else{
        $region_val = "Latin America";
          $cost_cover_val= "$8000";
          $cost_coy_val= "$3000";
      }
    } elseif((strpos($shomagazine, "MENA") !== false) || (strpos($shomagazine, "MENA") !== false)) {
      $check_region_var = preg_match("/{{region}}/i", $strMailContent);
      if ($check_region_var == 0) {
        $strMailContent = str_replace("2024", "in MENA 2024", $strMailContent);
        $region_val = "MENA";
        $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
      }else{
        $region_val = "MENA";
        $cost_cover_val= "9000 USD";
        $cost_coy_val= "5000 USD";
      }
    } else{
      $cost_cover_val= "$15,000";
          $cost_coy_val= "$5000";
          $region_val = "U.S";
    }
//     echo "\n  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ";
    $check_uk_comp = QB::query("select count(cid) uk_cnt from master_companies where cid=$compny_id and (other_country = 'United Kingdom' or other_country='UK' or country = 'United Kingdom' or country='UK' or country='United Kingdom (UK)' or other_country='United Kingdom (UK)')")->get();
    $uk_count = $check_uk_comp[0]->uk_cnt;
    if($uk_count > 0){
      $strMailContent = str_replace("Europe", "", $strMailContent);
      $strMailContent = str_replace("EUROPE", "", $strMailContent);
      $strMailContent = str_replace("Mena", "", $strMailContent);
      $strMailContent = str_replace("MENA", "", $strMailContent);
      $strMailContent = str_replace("APAC", "", $strMailContent);
      $strMailContent = str_replace("Apac", "", $strMailContent);
      $strMailContent = str_replace("apac", "", $strMailContent);
      $strMailContent = str_replace("Latin America", "", $strMailContent);
      $strMailContent = str_replace("LATIN AMERICA", "", $strMailContent);
      $strMailContent = str_replace("Canada", "", $strMailContent);
      $strMailContent = str_replace("CANADA", "", $strMailContent);
        $check_region_var = preg_match("/{{region}}/i", $strMailContent);
        if ($check_region_var == 0) {
          $strMailContent = str_replace("2024", "in UK 2024", $strMailContent);
          $region_val_europe=' and Europe';
          $region_val = "UK";
          $cost_cover_val= "9000 GBP";
          $cost_coy_val= "5000 GBP";
        }else{
          $region_val_europe=' and Europe';
          $region_val = "UK";
          $cost_cover_val= "9000 GBP";
          $cost_coy_val= "5000 GBP";
        }
    }
    $strMailContent = str_replace("{{and_europe}}", $region_val_europe, $strMailContent);

    
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
    if ($cntry == 'United States Of America' || $cntry == 'US' || $cntry == 'USA') {
      $cntry = 'United States Of America';
    }

    $single_statecountry = QB::query("select * from single_state_or_country_details where cid=$compny_id and status=1")->get();
    if(count($single_statecountry)>0){

      if((strpos($shomagazine, "Europe") !== false) || (strpos($shomagazine, "EUROPE") !== false) || (strpos($shomagazine, "Mena") !== false) || (strpos($shomagazine, "MENA") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "APAC") !== false) || (strpos($shomagazine, "Latin America") !== false) || (strpos($shomagazine, "LATIN AMERICA") !== false) || (strpos($shomagazine, "Canada") !== false) || (strpos($shomagazine, "CANADA") !== false) || (strpos($shomagazine, "Apac") !== false)) {
        $instate_country = "in ".$cntry;
        $instate_country = "in ".$region_val;
      }else{
        $instate_country = " in ".$states;
      }
    }else{
      if((strpos($shomagazine, "Europe") !== false) || (strpos($shomagazine, "EUROPE") !== false) || (strpos($shomagazine, "Mena") !== false) || (strpos($shomagazine, "MENA") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "APAC") !== false) || (strpos($shomagazine, "Latin America") !== false) || (strpos($shomagazine, "LATIN AMERICA") !== false) || (strpos($shomagazine, "Canada") !== false) || (strpos($shomagazine, "CANADA") !== false) || (strpos($shomagazine, "Apac") !== false)) {
        $instate_country = "in ".$cntry;
        $instate_country = "in ".$region_val;
      }else{
        $instate_country = "";
      }
    }
    $query_get_value=QB::query("select (select primary_term from company_recognition_terms where id=s.left_rec_id) left_name,(select primary_term from company_recognition_terms where id=s.right_rec_id) right_name from company_category_of_year s where cid=$compny_id limit 1")->get();
    if(count($query_get_value)>0){
      $left_names = $query_get_value[0]->left_name;
      $right_names = $query_get_value[0]->right_name;
      if($left_names == 'Best-in-{{state}}' || $right_names == 'Best-in-{{state}}'){
        $instate_country = '';
      }
    }

    $subject_f = str_replace("{{in_country_state}}", $instate_country, $subject_f);
    $strMailContent = str_replace("{{in_country_state}}", $instate_country, $strMailContent);
    $strMailContent = str_replace("{{state}}", $states, $strMailContent);
    $strMailContent = str_replace("{{country}}", $cntry, $strMailContent);

      $check_coy_mark = QB::query("select coy_flag,date(addeddate) addeddate,left_rec_id,right_rec_id from company_category_of_year where cid=$compny_id")->get();
      $coy_flag_kk = $check_coy_mark[0]->coy_flag;
      $coy_left_rec_id = $check_coy_mark[0]->left_rec_id;
      $coy_right_rec_id = $check_coy_mark[0]->right_rec_id;

      if($mail_type == 'First Mail' || ($coy_addeddate < $firstsenddate && count($get_firstsenddate) > 0)){
        if($coy_flag_kk == 1 || $coy_flag_kk == 3){
          $company_category_oty = "Company of the Year";
        }elseif($coy_flag_kk == 2 || $coy_flag_kk == 4){
          $company_category_oty = "of the Year";
        }elseif($coy_flag_kk == 0 && (($coy_left_rec_id !='' && $coy_left_rec_id != 0) || ($coy_right_rec_id !='' && $coy_right_rec_id != 0))){
          if($coy_left_rec_id!='' && $coy_left_rec_id!=0){
            $getleft_names = QB::query("select primary_term from company_recognition_terms where id=$coy_left_rec_id")->get();
            if(count($getleft_names)>0){
              $left_names = $getleft_names[0]->primary_term;
              if($left_names == '[Blank]'){
              }else{
                $top_term = ' '.$left_names;
              }
            }
          }
          if($coy_right_rec_id!='' && $coy_right_rec_id!=0){
            $getright_names = QB::query("select primary_term from company_recognition_terms where id=$coy_right_rec_id")->get();
            if(count($getright_names)>0){
              $right_names = $getright_names[0]->primary_term;
              if($right_names == '[Blank]'){
              }else{
                $company_category_oty = ' '.$right_names;
              }
            }
          }
        }
      }else{
        if($premium_condition == 1 || $premium_condition == 0){
          $company_category_oty = "Company of the Year";
        }
      }
    
    if($left_names == 'Best-in-{{state}}' || $right_names == 'Best-in-{{state}}'){
        $instate_country = '';
      }
    
    if($receiver_name == ''){
      $receiver_name = '{{name}}';
    }
$subject_f = str_replace("{{in_country_state}}", $instate_country, $subject_f);
$subject_f = str_replace("{{state}}", $states, $subject_f);
$subject_f = str_replace("{{country}}", $cntry, $subject_f);
    $strMailContent = str_replace("{{in_country_state}}", $instate_country, $strMailContent);
    $strMailContent = str_replace("{{state}}", $states, $strMailContent);
    $strMailContent = str_replace("{{country}}", $cntry, $strMailContent);
    $strMailContent = str_replace("{{company_of_the_year}}", $company_category_oty, $strMailContent);
$subject_f= str_replace("{{top}}", $top_term, $subject_f);
$strMailContent= str_replace("{{top}}", $top_term, $strMailContent);
$subject_f= str_replace("{{company_of_the_year}}", $company_category_oty, $subject_f);
    $strMailContent = str_replace("{{cost_cover}}", $cost_cover_val, $strMailContent);
    $strMailContent = str_replace("{{cost_COY}}", $cost_coy_val, $strMailContent);
    $strMailContent = str_replace("{{region}}", $region_val, $strMailContent);
    
    $strMailContent = str_replace("{{category}}", $status_name, $strMailContent);
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
    $strMailContent = str_replace("{{closedcontent}}", $field7, $strMailContent);

    

    $strMailContent = str_replace("{{firstname}}", $shof_name, $strMailContent);
    $strMailContent = str_replace("{{lastname}}", $shol_name, $strMailContent);
    $shosignature = str_replace("{{salesphone}}", $shophone_no, $shosignature);
    $strMailContent = str_replace("{{subscribercount}}", $subscriber_count, $strMailContent);

    $strMailContent = str_replace("{{projectname}}", $rem_pname, $strMailContent);

    $strMailContent = str_replace("{{aboutMagazine}}", $aboutMagazine, $strMailContent);
    $strMailContent = str_replace("{{oldmagazine}}", $oldmagazine, $strMailContent);
    $strMailContent = str_replace("{{oldproject}}", $oldproject, $strMailContent);


    if ($shof_name != '' && $shof_name != null && $shol_name != '' && $shol_name != null && $shophone_no != 0) {

      $shosignature = str_replace("{{firstname}}", $shof_name, $shosignature);
      $shosignature = str_replace("{{lastname}}", $shol_name, $shosignature);
      $shosignature = str_replace("{{salesphone}}", $shophone_no, $shosignature);
      $shosignature = str_replace("{{magazinename}}", $shomagazine, $shosignature);
      $shosignature = str_replace("{{magazinewithlink}}", $mnameurl, $shosignature);
      $shosignature = str_replace("{{physical_add}}", $phy_address, $shosignature);
    }
    if($shosignature == ''){
      $shosignature="{{signature}}";
      $blockmail = 1;
    }
    $strMailContent = str_replace("{{signature}}", $shosignature, $strMailContent);

    $strMailContent = str_replace("{{category}}", $cmp_status, $strMailContent);

    $strMailContent = str_replace("{{person_id_track}}", $add_person_id, $strMailContent);
    $strMailContent = str_replace("{{compose_id_track}}", $unique_id, $strMailContent);

    $receiver_email_idd = self::encrypt_decrypt('encrypt', $receiver_email_id);
    $project_idd = self::encrypt_decrypt('encrypt', $project_sel_f);

    $person_track_spark =  $add_person_id;
    $compose_track_spark = $unique_id;


    $pname = self::get_project($project_sel_f);
    $sub_domain = str_replace(' ', '-', $pname);

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
        $unsubscribeLinkURL = self::getUnsubscribeLink_new_one($magid, $sender_domain, $sub_domain, $rep_with_word4);
      } else {
        $unsubscribeLinkURL = self::getUnsubscribeLink_new($magid, $sender_domain, $sub_domain, $rep_with_word4, 0, 0,$old_new_sign);
      }

      $unsubscribeLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_idd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{project_idd}}", $project_idd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $unsubscribeLinkURL);

      $unsubscribeLinkURL = str_replace("{{sender_email}}", $sender_email, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{mail_type}}", $mail_type, $unsubscribeLinkURL);

      $unsubscribeLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_emaill, $unsubscribeLinkURL);

      $unsubscribeLinkURL = str_replace("{{project_iddd}}", $pidd, $unsubscribeLinkURL);
      $unsubscribeLinkURL = str_replace("{{unsub_word}}", $rep_with_word4, $unsubscribeLinkURL);

      $strMailContent = str_replace($rep_with_word4, $unsubscribeLinkURL, $strMailContent);
    }

    $rep_with_wordp = '';
    $spamlinkLinkURL = self::getUnsubscribeLink_new($magid, $sender_domain, $sub_domain, $rep_with_wordp, 0, 1,$old_new_sign);

    $spamlinkLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_idd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_emaill, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_idd}}", $project_idd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_iddd}}", $pidd, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $spamlinkLinkURL);

    $spamlinkLinkURL = str_replace("{{sender_email}}", $sender_email, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{mail_type}}", $mail_type, $spamlinkLinkURL);

    $strMailContent = str_replace("{{spamlink}}", $spamlinkLinkURL, $strMailContent);

    $strMailTextVersion = $strMailContent;

    $strSubject = $subject_f;
    if ($this->special_normal_premium == 1) {
//       echo "\n  bbbbbbbbbbbb ";
      $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid limit 1) magid from master_companies m where cid = $compny_id ")->get();
      $magid = $comp_details[0]->magid;
      if ($magid == '') {
        $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ")->get();
      }

      $status_name = $comp_details[0]->status_name;
      $strSubject = str_replace("{{category}}", $status_name, $strSubject);
    }

//     echo "\nRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR";

    $strSubject = str_replace("{{name}}", $receiver_name, $strSubject);
    $strSubject = str_replace("{{lname}}", $lname, $strSubject);
    $strSubject = str_replace("{{company}}", $company_name, $strSubject);
    $strSubject = str_replace("{{designation}}", $designation_email_f, $strSubject);
    $strSubject = str_replace("{{magazinename}}", $shomagazine, $strSubject);
    $strSubject = str_replace("{{subscribercount}}", $subscriber_count, $strSubject);
    $strSubject = str_replace("{{category}}", $cmp_status, $strSubject);
    $strSubject = str_replace("{{firstname}}", $shof_name, $strSubject);
    $strSubject = str_replace("{{lastname}}", $shol_name, $strSubject);
    $strSubject = str_replace("{{magazinewithlink}}", $mnameurl, $strSubject);
    $strSubject = str_replace("{{magazineurl}}", $magazinekk_url, $strSubject);

    $strSubject = str_replace("{{projectname}}", $rem_pname, $strSubject);

    $strSubject = str_replace("{{aboutMagazine}}", $aboutMagazine, $strSubject);
    $strSubject = str_replace("{{oldmagazine}}", $oldmagazine, $strSubject);
    $strSubject = str_replace("{{oldproject}}", $oldproject, $strSubject);
    $strSubject = str_replace("{{company_of_the_year}}", $company_category_oty, $strSubject);

    if($premium_condition == 1 || $premium_condition == 0){
      $check_yearlisting = QB::query("select * from next_year_listing where cid=$compny_id")->get();
      if(count($check_yearlisting)>0){
        $strMailTextVersion = str_replace("2024","2025", $strMailTextVersion);
        $strSubject = str_replace("2024","2025", $strSubject);
      }
    }

    $strMailTextVersion = str_replace("2024","2025", $strMailTextVersion);
    $strSubject = str_replace("2024","2025", $strSubject);

    // return $strMailContent;
  }
