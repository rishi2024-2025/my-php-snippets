<?php

public function draftEmailGmailAPI_prahar($receiver_email_id, $receiver_name, $company_name, $designation_email_f, $project_sel_f, $magid, $compny_id, $mail_type, $sender_email, $subject_f, $mail_content, $unique_id, $add_person_id, $client_g, $field5, $field6, $field7, $cmp_status, $draft_name, $sender_domain, $lname = null, $signature = null, $signature_swap = null)
  {
    if ($lname != null && $lname != '') {
      $lname = $lname;
    }
    $blockmail = 0;
    /*New code for Signature by kajol */
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
    /*New code for Signature end*/

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

    if (($magid == 1 || $magid == 49) && strpos($strMailContent, "{{casestudypara1}}") !== false && $draft_name == 'Past Client' && $project_sel_f != 3092 && $project_sel_f != 2577) {

      $getPastClientCount = QB::query("select count(id) past_clientcnt from emailprocess.master_companies_track where cid=$compny_id and pid=$project_sel_f and action_type='casestudy past client'")->get();
      $get_past_clientcnt = $getPastClientCount[0]->past_clientcnt;
      if ($get_past_clientcnt == 0) {
        $query = QB::query("insert into emailprocess.master_companies_track (cid,pid,uid,action_type,date) values($compny_id,$project_sel_f,$this->log_userId,'casestudy past client',now())");
      }

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

    echo "\n -------- " . "select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid) magid from master_companies m where cid = $compny_id ";
    $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid limit 1) magid from master_companies m where cid = $compny_id ")->get();
    echo "\n   <<<<<<<<<<<<<<<<<<<< ";
    $magid = $comp_details[0]->magid;
      if ($magid == '' || $magid == 'NULL' || $magid == 0) {
      echo "\n  ========== "."select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ";
      $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ")->get();
    }

    echo "\n  qqqqqqqqqqqqqqqq ";
    $p3_status = $comp_details[0]->p3_status;
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
    echo "\n  ========== "."select f_name,l_name,subscriber_count,phone_no,magid,phy_address,old_new_sign from special_child_details where child_email_id = '$this->sender_email' $magid_cond limit 1";
    $getflname = QB::query("select f_name,l_name,subscriber_count,phone_no,magid,phy_address,old_new_sign from special_child_details where child_email_id = '$this->sender_email' $magid_cond limit 1")->get();
    if(count($getflname)==0){
      $signature_track = QB::query("insert into signature_mismatched(pid,cid,mail_type,magid,sender_email,compose_id,status,added_date) values($pidd,$compny_id,'$mail_type','$magid','$this->sender_email',$unique_id,2,now())");
    }
    $shof_name = $getflname[0]->f_name;
    $shol_name = $getflname[0]->l_name;
    $old_new_sign = $getflname[0]->old_new_sign;
    $subscriber_count = $getflname[0]->subscriber_count;
    $shophone_no = $getflname[0]->phone_no;
    $phy_address = $getflname[0]->phy_address;
    $magid_kk = $magid;
    if ($magid_kk != '' && $magid_kk != 'NULL' && $magid_kk != 0) {
      echo "\n "."select count(*) cnt from upload_magazines_subdomains where magid = $magid_kk and magazine_subdomain='$sender_domain'";
      $get_subdomain = QB::query("select count(*) cnt from upload_magazines_subdomains where magid = $magid_kk and magazine_subdomain='$sender_domain'")->get();
      $get_subdomain_cnt = $get_subdomain[0]->cnt;
      if ($get_subdomain_cnt == 0) {
        $blockmail = 1;
        $return_val = "email_domain_not_match_magazine";
        return $return_val;
      }
      $outlook_draft = QB::query("select * from master_companies where  cid=$compny_id and extra_field2='1'")->get();
      if(count($outlook_draft) == 0){
        $outlook_kaj_flag =0;
        $check_domain = QB::query("SELECT id FROM upload_magazines_subdomains u WHERE u.domain_hold=1 and u.magazine_subdomain='$sender_domain'")->get();
        if(count($check_domain)>0){
          $blockmail = 1;
          $return_val = "email_hold_not_ot";
          return $return_val;
        }
      }else{
        $outlook_kaj_flag =1;
        $check_domain = QB::query("SELECT id FROM upload_magazines_subdomains u WHERE u.domain_hold_ot=1 and u.magazine_subdomain='$sender_domain'")->get();
        if(count($check_domain)>0){
          $blockmail = 1;
          $return_val = "email_hold_not_ot";
          return $return_val;
        }
      }
    } else {
      $blockmail = 1;
      $return_val = "email_domain_not_match_magazine";
      return $return_val;
    }
    echo "\n  eeeeeeeeeeeeeeee ";
    $shomagazine = self::get_magazine($magid);
    echo "\n  select magazine_url,mag_description from magazine_details where magid = $magid ";
    $get_magurl = QB::query("select magazine_url,mag_description from magazine_details where magid = $magid")->get();
    $show_magurl = $get_magurl[0]->magazine_url;
    $mnameurl = "<a href='http://www." . $show_magurl . "' target='_blank'>" . $shomagazine . "</a>";
    $magazinekk_url = $show_magurl;

    $aboutMagazine = $get_magurl[0]->mag_description;
    if ($aboutMagazine == '') {
      $aboutMagazine = "{{aboutMagazine}}";
    }echo "\n  ddddddddddddddd ";
    
    if ($status_name == 'Rank 11') {
      echo "\n  ========== "."select pid, cid, cname from master_companies where curl = '$add_curl' and status=1 order by cid desc limit 1";
      $select_oldpid = QB::query("select pid, cid, cname from master_companies where curl = '$add_curl' and status=1 order by cid desc limit 1")->get();
      if (count($select_oldpid) > 0) {
        $get_oldpid = $select_oldpid[0]->pid;
        $get_oldcid = $select_oldpid[0]->cid;
        $get_oldcname = $select_oldpid[0]->cname;
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
    echo "\n  aaaaaaaaaaaaaaaaaaaaa ";

    $today = date('Y-m-d');

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
        echo "\n  fffffffffffffffffffffffffff ";
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

            $check_online = QB::query("select date(online_date) online_date from projectinfo p join master_companies m on m.pid=p.pid where curl='$check_rankkk_curl' and m.status=1 order by cid desc limit 1")->get();
            $dateToCheck = $check_online[0]->online_date;
            $currentTimestamp = time();
            $targetTimestamp = strtotime($dateToCheck);
            $oneYearFromNowTimestamp = strtotime('-1 year');echo "\n  ffffffffffffffff ";
            // if (($targetTimestamp > $oneYearFromNowTimestamp) || $check_rankkk_rank == 5) {
            $closure_magazine = QB::query("select pid from master_companies where curl='$check_rankkk_curl' and status=1 order by cid desc limit 1")->get();
$get_closures_pid = $closure_magazine[0]->pid;
$get_closures_magid = self::magazine_id($get_closures_pid);
$closure_magaizne = QB::query("select count(*) magid_count from magazine_details where magid =$get_closures_magid and magazine_status = 0")->get();
$magidcount = $closure_magaizne[0]->magid_count;
$listing_comp = QB::query("select count(*) listing_count from traffic_restrictions where cid =$compny_id")->get();
$listcount = $listing_comp[0]->listing_count;
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
                  } else {
                    $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                    if (count($check_notmoved) == 0) {
                      $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl', '$get_traffic_click', '$get_traffic_view', 'Traffic click count is low', now())");
                    } else {
                      $check_notmoved_id = $check_notmoved[0]->id;
                      $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt='$get_traffic_click' , traffic_view='$get_traffic_view',comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
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
                    $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=0 , traffic_view=0,comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
                  }
                  $return_val = "no_traffic_count";
                  return $return_val;
                  $blockmail = 1;
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
                        }else{
                        $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                        if (count($check_notmoved) == 0) {
                          $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl', '$get_traffic_click', '$get_traffic_view', 'Traffic click count is low', now())");
                        } else {
                          $check_notmoved_id = $check_notmoved[0]->id;
                          $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt='$get_traffic_click' , traffic_view='$get_traffic_view',comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
                        }
                        $return_val = "traffic_count_is_low";
                        return $return_val;
                        $blockmail = 1;
                      }
                    }
                  } else {
                    $check_notmoved = QB::query("select id from rank_10_11_5_mail_not_moved where added_date between '$today 00:00:00' and '$today 23:59:59' and pid=$project_sel_f and cid=$compny_id and curl='$check_rankkk_curl'")->get();
                    if (count($check_notmoved) == 0) {
                      $insert_notmoved = QB::query("insert into rank_10_11_5_mail_not_moved (pid,cid,curl,traffic_cnt,traffic_view,comment,added_date) values($project_sel_f, $compny_id, '$check_rankkk_curl',0, 0, 'Traffic click count is low', now())");
                    } else {
                      $check_notmoved_id = $check_notmoved[0]->id;
                      $update_notmove = QB::query("update rank_10_11_5_mail_not_moved set traffic_cnt=0 , traffic_view=0,comment='Traffic click count is low' where id=$check_notmoved_id limit 1");
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
    $check_unsubscribe_line = strpos($strMailContent, "{{unsubscribe_line}}");
      if ($check_unsubscribe_line !== false) {
        if ($mail_type == 'First Mail') {
  
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
        
          $unsubscribe_line_word_count = str_word_count($unsubscribe_word);
          if ($unsubscribe_line_word_count < 5) {
            $blockmail = 1;
            $return_val = "unsubscribe_line_is_less_than_five_words";
            return $return_val;
          }
        }else {
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
          $unsubscribe_line_word_count = str_word_count($unsubscribe_word);
          if ($unsubscribe_line_word_count < 5) {
            $blockmail = 1;
            $return_val = "unsubscribe_line_is_less_than_five_words";
            return $return_val;
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
    echo "\n  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ";
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
        // $instate_country = "in ".$cntry;
        $instate_country = "in ".$region_val;
      }else{
        $instate_country = " in ".$states;
      }
    }else{
      if((strpos($shomagazine, "Europe") !== false) || (strpos($shomagazine, "EUROPE") !== false) || (strpos($shomagazine, "Mena") !== false) || (strpos($shomagazine, "MENA") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "UK") !== false) || (strpos($shomagazine, "APAC") !== false) || (strpos($shomagazine, "Latin America") !== false) || (strpos($shomagazine, "LATIN AMERICA") !== false) || (strpos($shomagazine, "Canada") !== false) || (strpos($shomagazine, "CANADA") !== false) || (strpos($shomagazine, "Apac") !== false)) {
        // $instate_country = "in ".$cntry;
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

    $check_coy = QB::query("select premium_normal from master_companies where cid=$compny_id")->get();
    $premium_condition = $check_coy[0]->premium_normal;
$premium_condition = 1;
    if($premium_condition == 1 || $premium_condition == 0){
      $company_category_oty = "Company of the Year";
    }
      $check_coy_mark = QB::query("select coy_flag,date(addeddate) addeddate,left_rec_id,right_rec_id from company_category_of_year where cid=$compny_id")->get();
      $coy_flag_kk = $check_coy_mark[0]->coy_flag;
      $coy_addeddate = $check_coy_mark[0]->addeddate;
      $coy_left_rec_id = $check_coy_mark[0]->left_rec_id;
      $coy_right_rec_id = $check_coy_mark[0]->right_rec_id;
      $get_firstsenddate = QB::query("select date(first_senddate) first_senddate from addperson_detail where cid=$compny_id and email_id = '$receiver_email_id' and trim(first_senddate)!='' and first_senddate is not null and first_senddate!='0000-00-00 00-00'")->get();
      if (count($get_firstsenddate) > 0) {
        $firstsenddate = $get_firstsenddate[0]->first_senddate;
      }
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

if($old_new_sign == 0){
      $shosignature = '<p style="font-family: Georgia;font-size: 12px;line-height:1.5;"><span style=\"font-family:georgia\">Regards,</span><br />
      <span style=\"font-family:georgia\">{{firstname}}<br />______________</span><br />
      <span style=\"font-family:georgia\">{{firstname}} {{lastname}}</span><br />
      <span style=\"font-family:georgia\">{{magazinename}}</span><br />
      <span style=\"font-family:georgia\">{{salesphone}}</span><br />
      <span style=\"font-family:georgia\">______________</span></p>';

}else{
  $encripted_compose= self::encrypt_decrypt('encrypt', $unique_id);
  $shosignature = '<table style="width: 100%; line-height: 1.5; font-family: EuclidCircularB, Arial, Helvetica, sans-serif;">
    <tbody><tr>
        <td style="vertical-align: top; width: 38%;">
         <p style="font-size: 15px;">Best Regards,</p><p style="font-size: 18px;"><b>' . ucfirst($shof_name) . '  ' . ucfirst($shol_name) . ' |</b> ' . $shomagazine . '</p>
            <p style="color: #686464; font-size: 14px;">Senior Relationship Specialist</p>
            <p style="font-size: 12px;">600 S Andrews Ave Suite 405, Fort Lauderdale, FL 33301</p>
            <p style="font-size: 12px;">Main: {{salesphone}}</p>
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
      $return_val = "not_match_signature";
      return $return_val;
    }
    $strMailContent = str_replace("{{signature}}", $shosignature, $strMailContent);




    $lowercontend = $lowersign = $return_val = '';

    /*signature match condition*/
    $domainsender = explode("@", $sender_email);
      $firstname = $domainsender[0];
      $firstname1 = explode(".", $firstname);
      if (count($firstname1) == 2) {
        $signname = substr($firstname1[0], 0, -1);
      } else {
        $signname = $firstname1[0];
      }
      $lowercontend = strtolower($strMailContent);
      $lowersign = strtolower($signname);
      if (strpos($lowercontend, $lowersign) !== false) {
        $return = "matched_signature";
      } else {
        $return_val = "not_match_signature";
        return $return_val;
      }

    /*signature match condition end*/

    unset($field7);
    unset($exception);
    unset($bulk);


    $strMailContent = str_replace("{{category}}", $cmp_status, $strMailContent);

    $strMailContent = str_replace("{{person_id_track}}", $add_person_id, $strMailContent);
    $strMailContent = str_replace("{{compose_id_track}}", $unique_id, $strMailContent);


    //$strMailTextVersion = strip_tags($strMailContent, '');

    $receiver_email_idd = self::encrypt_decrypt('encrypt', $receiver_email_id);
    $project_idd = self::encrypt_decrypt('encrypt', $project_sel_f);

    $person_track_spark =  $add_person_id;
    $compose_track_spark = $unique_id;


    $pname = self::get_project($project_sel_f);
    $sub_domain = str_replace(' ', '-', $pname);

    $person_track_spark1 =  self::encrypt_decrypt('encrypt', $add_person_id);
    $compose_track_spark1 = self::encrypt_decrypt('encrypt', $unique_id);

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

    $strRawMessage = "";
    $boundary = uniqid(rand(), true);
    $boundarya = uniqid(rand(), true);
    $subjectCharset = $charset = 'utf-8';
    $strToMailName = $receiver_name;
    $strToMail = $receiver_email_id;
    $strSesFromName = $this->sender_name;
    $strSesFromEmail = $this->sender_email;
    echo "\n  cccccccccccccccccccccccc ";
    $strSubject = $subject_f;
    if ($this->special_normal_premium == 1) {
      echo "\n  bbbbbbbbbbbb ";
      $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select magid from special_company_magid k where pid=m.pid and category =m.p3_status and cid=m.cid limit 1) magid from master_companies m where cid = $compny_id ")->get();
      $magid = $comp_details[0]->magid;
      if ($magid == '') {
        $comp_details = QB::query("select cname, curl,p3_status,(select status_name  from emailprocess.companytype_status where status=m.p3_status limit 1) status_name,(select k.magid from special_project_details k join special_child_details a on a.magid=k.magid where k.pid=m.pid and k.category=m.p3_status and child_email_id='$this->sender_email' order by k.id desc limit 1) magid from master_companies m where cid = $compny_id ")->get();
      }
      $p3_status = $comp_details[0]->p3_status;
      $status_name = $comp_details[0]->status_name;
      $magid1 = $comp_details[0]->magid1;
      $magid = $comp_details[0]->magid;
      if ($magid1 != '' && $magid1 != 0) {
        $magid = $magid1;
      }
      $strSubject = str_replace("{{category}}", $status_name, $strSubject);
    }

    echo "\nRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR";

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
    if (trim($strSubject) == '') {
      $blockmail = 1;
      $return_val = "subject_message_is_empty";
    }
    if (trim($strMailTextVersion) == '') {
      $blockmail = 1;
      $return_val = "subject_message_is_empty";
    }

      $check_variable_msg1 = preg_match("/}}/i", $strMailTextVersion);
      $check_variable_msg2 = preg_match("/}/i", $strMailTextVersion);
      $check_variable_msg3 = preg_match("/{/i", $strMailTextVersion);
      $check_variable_msg = preg_match("/{{/i", $strMailTextVersion);
      $check_variable_sub = preg_match("/{{/i", $strSubject);
      $check_variable_sub1 = preg_match("/}}/i", $strSubject);
      $check_variable_sub2 = preg_match("/}/i", $strSubject);
      $check_variable_sub3 = preg_match("/{/i", $strSubject);
      if ($check_variable_sub > 0 || $check_variable_sub1 > 0 || $check_variable_sub2 > 0 || $check_variable_sub3 > 0) {
      $blockmail = 1;
      echo "\n  >>>>>>>>> ".$strMailTextVersion;
      echo "\n  >>>>>>>>> ".$strSubject;
      $strMailTextVersionkk = addslashes($strMailTextVersion);
        $strSubjectk = addslashes($strSubject);
        echo "<li> 111 " . "insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubjectk','$strMailTextVersionkk',$unique_id,1,now())";
        $variable_track = QB::query("insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubjectk','$strMailTextVersionkk',$unique_id,1,now())");
        $return_val = "variable_not_replaced";
    }

    if ($check_variable_msg > 0 || $check_variable_msg1 > 0 || $check_variable_msg2 > 0 || $check_variable_msg3 > 0) {
      $blockmail = 1;
      echo "\n  <<<<<<<<< ".$strMailTextVersion;
      echo "\n  <<<<<<<<< ".$strSubject;
      $strMailTextVersionkk = addslashes($strMailTextVersion);
        $strSubjectk = addslashes($strSubject);
        echo "<li> 111 " . "insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubjectk','$strMailTextVersionkk',$unique_id,1,now())";
        $variable_track = QB::query("insert into variable_not_replaced(pid,cid,subject,content,compose_id,status,added_date) values($project_sel_f,$compny_id,'$strSubjectk','$strMailTextVersionkk',$unique_id,1,now())");
        $return_val = "variable_not_replaced";
    }
    if (strlen($strMailTextVersion) < 200) {
      $blockmail = 1;
      $return_val = "mail_content_lessthen_200";
    }

    $check_6k_msg = preg_match("/ 6,000/i", $strMailTextVersion);
    if ($check_6k_msg > 0) {
      $blockmail = 1;
      $return_val = "$6,000 is coming";
    }
    echo "\n >>>>>>>>>>> ".$blockmail.'-'.$return_val;
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
      //$strRawMessage .= $strMailTextVersion;
      $strRawMessage .= "\r\n--{$boundarya}--\r\n";

      $strRawMessage .= "\r\n--{$boundary}\r\n";

      $strRawMessage .= '--' . $boundary . "--\r\n";
      $return_val = "";
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
    return $return_val;
  }

