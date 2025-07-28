 <?php
 
public function draftEmailGmailAPI_prahar($receiver_email_id, $receiver_name, $company_name, $designation_email_f, $project_sel_f, $magid, $compny_id, $mail_type, $sender_email, $subject_f, $mail_content, $unique_id, $add_person_id, $client_g, $field5, $field6, $field7, $cmp_status, $draft_name, $sender_domain, $lname = null, $signature = null, $signature_swap = null, $seg_type, $session_id)
{
    $getpname = "{{newprojectwithyear}}";
    $getmname = "{{newmagazine}}";
    $getpname2 = "{{newproject}}";
    $getpname1 = '';
    $aboutMagazine = "{{aboutMagazine}}";
    $oldproject = "{{oldproject}}";
    $oldmagazine = "{{oldmagazine}}";
    $oldmnameurl = "{{oldmagazinewithlink}}";
    $show_ranking_name = "{{ranking_name}}";
    $signature_new = "{{signature}}";
    $states = "{{state}}";
    $cntry = "{{country}}";
    $jobtitles = "{{jobtitles}}";
    $project_category = "{{project_category}}";
    $cost_word = "{{cost_para}}";
    $disclaimer_word = "{{disclaimer}}";
    $lastline_word = "{{last_line}}";
    $unsubscribe_word = "{{unsubscribe_line}}";
    $first_word = "{{first_line}}";
    $cost_cover_val = "{{cost_cover}}";
    $cost_coy_val = "{{cost_COY}}";
    $cost_profille_val = "{{cost_profile}}";
    $region_val = "{{region}}";
    $in_region_val = "{{in_region}}";
    $subscriber_count = "{{subscribercount}}";
    $partner_namek = "{{partnername}}";
    $left_name_value = "{{top}}";
    $right_name_value = "{{company_of_the_year}}";
    $instate_country = "{{in_country_state}}";
    $closed_client_1k = "{{closedcontent1}}";
    $closed_client_2k = "{{closedcontent2}}";
    $closed_client_3k = "{{closedcontent3}}";
    $old_status_name = "{{old_project_category}}";
    $categorycustomization = "{{categorycustomization}}";
    $company_category_oty = "{{company_of_the_year}}";
    $general_cat_name = "{{general_category}}";
    $first_name_kk = "{{firstname}}";
    $last_name_kk = "{{lastname}}";
    $sender_fname_k = "{{sender_fname}}";
    $sender_lname_k = "{{sender_lname}}";
    $salesphone = "{{Sales Phone Not Added!!}}";
    $mnameurl = "{{magazinewithlink}}";
    $mnameurl_new = "{{magazinewithlink_new}}";
    $old_new_website_link = "{{companypreviousprofile}}";
    $info_content = "{{info}}";
    $caseStudyContent = $caseStudyContent2 = "";
    $p3_status_kk = null;
    $project_region_status = 0;
    $project_region_status2 = 0;
    $get_traffic_click = 0;
    $get_traffic_view = 0;
    $blockmail = 0;
    $special_kaj = 0;

    $strMailContent = $mail_content;
    $strMailTextVersion = $strMailContent;
    $strMailTextVersion = str_replace("(CXO)",'', $strMailTextVersion);
    $strMailTextVersion = str_replace("(cxo)",'', $strMailTextVersion);

    $total_block = substr_count($mail_content, '<blockquote>');
    $gradient = ["Aqua", "Aquamarine", "Black", "Blue", "BlueViolet", "Brown", "CadetBlue", "DarkBlue", "DarkCyan", "DarkGreen", "DarkMagenta"];
    for ($i = 0; $i < $total_block; $i++) {
        $rand_keys = array_rand($gradient, 2);
        $block_data = '<blockquote style="margin:0 0 0 .8ex;border-left:1px ' . $gradient[$rand_keys[0]] . ' solid;padding-left:1ex">';
        $strMailContent = preg_replace('/' . preg_quote('<blockquote>', '/') . '/', $block_data, $strMailContent, 1);
    }

    if ($project_sel_f) {
        $getpmname = QB::query("SELECT region_status, region_status2, pname, pid, magid, year,(SELECT magazine_name FROM magazine_details WHERE magid = p.magid) AS mname,status, print_online_hold_status, special FROM projectinfo p WHERE pid = $project_sel_f")->get();
        
        if (!empty($getpmname)) {
            $special_kaj = $getpmname[0]->special;
            $getyear = $getpmname[0]->year;
            $getpname = $getpmname[0]->pname;
            $getpname1 = explode($getyear, $getpname);
            $getpname2 = $getpname1[0] ?? '';
            $getmname = $getpmname[0]->mname;
            $add_magid = $getpmname[0]->magid;
            $project_closed_status = $getpmname[0]->status;
            $project_region_status = $getpmname[0]->region_status;
            $project_region_status2 = $getpmname[0]->region_status2;
            
            if ($add_magid) {
                $get_magurl = QB::query("SELECT magazine_url, mag_description FROM magazine_details WHERE magid = $add_magid")->get();
                if (!empty($get_magurl)) {
                    $aboutMagazine = $get_magurl[0]->mag_description ?: "{{aboutMagazine}}";
                    $show_magurl = $get_magurl[0]->magazine_url;
                    $mnameurl = "<a href='http://www.$show_magurl' target='_blank'>$getmname</a>";
                    $mnameurl_new = "$getmname $show_magurl";
                }
            }
        }
    }

    if ($compny_id) {
        $select_oldpid = QB::query("SELECT (SELECT pid FROM collection.client_details WHERE client_id = mi.cid LIMIT 1) AS Proj  FROM master_companies_info mi WHERE master_id = $compny_id")->get();
        
        if (!empty($select_oldpid) && $select_oldpid[0]->Proj) {
            $get_oldpid = $select_oldpid[0]->Proj;
            $check_mag = QB::query("SELECT magid, pname FROM projectinfo WHERE pid = $get_oldpid")->get();
            
            if (!empty($check_mag)) {
                $old_mag = $check_mag[0]->magid;
                $oldproject = $check_mag[0]->pname;
                $oldmagazine = QB::query("SELECT magazine_name FROM magazine_details WHERE magid = $old_mag")->get()[0]->magazine_name ?? "{{oldmagazine}}";
                
                $get_oldmagurl = QB::query("SELECT magazine_url FROM magazine_details WHERE magid = $old_mag")->get();
                if (!empty($get_oldmagurl)) {
                    $show_oldmagurl = $get_oldmagurl[0]->magazine_url;
                    $oldmnameurl = "<a href='http://www.$show_oldmagurl' target='_blank'>$oldmagazine</a>";
                }
            }
        } else {
            $select_oldpid_agin = QB::query("SELECT curl FROM master_companies WHERE cid = $compny_id")->get();
            if (!empty($select_oldpid_agin)) {
                $curl = $select_oldpid_agin[0]->curl;
                $fetch_old_pid = QB::query("SELECT pid FROM master_companies WHERE curl = '$curl' AND status = 1 ORDER BY cid DESC")->get();
                if (!empty($fetch_old_pid)) {
                    $fetch_old = $fetch_old_pid[0]->pid;
                    $check_mag = QB::query("SELECT magid, pname FROM projectinfo WHERE pid = $fetch_old")->get();
                    if (!empty($check_mag)) {
                        $old_mag = $check_mag[0]->magid;
                        $oldproject = $check_mag[0]->pname;
                        $oldmagazine = QB::query("SELECT magazine_name FROM magazine_details WHERE magid = $old_mag")->get()[0]->magazine_name ?? "{{oldmagazine}}";
                        $get_oldmagurl = QB::query("SELECT magazine_url FROM magazine_details WHERE magid = $old_mag")->get();
                        if (!empty($get_oldmagurl)) {
                            $show_oldmagurl = $get_oldmagurl[0]->magazine_url;
                            $oldmnameurl = "<a href='http://www.$show_oldmagurl' target='_blank'>$oldmagazine</a>";
                        }
                    }
                }
            }
        }
    }

    if ($oldmagazine != $getmname) {
        $differentoldmagazine_val = "which belongs to the same organization that owns {{oldmagazine}}.";
        $strMailContent = str_replace("{{differentoldmagazine}}", $differentoldmagazine_val, $strMailContent);
    } else {
        $strMailContent = str_replace("{{differentoldmagazine}}", '', $strMailContent);
    }

    if ($compny_id) {
        $check_japan = QB::query("SELECT country, p3_status, general_category, other_country, master_com_id FROM master_companies WHERE cid = $compny_id LIMIT 1")->get();
        
        if (!empty($check_japan)) {
            $cntry = $check_japan[0]->country;
            $p3_status_kk = $check_japan[0]->p3_status;
            $general_category = $check_japan[0]->general_category;
            $master_com_id = $check_japan[0]->master_com_id;
            
            if ($cntry == 'Japan' && $lname) {
                $lname .= ' San';
            }
            
            if ($general_category) {
                $get_generatcat = QB::query("SELECT category_name FROM company_wise_general_categories WHERE id = $general_category LIMIT 1")->get();
                $general_cat_name = !empty($get_generatcat) ? $get_generatcat[0]->category_name : '{{general_category}}';
            }
            
            $get_ranking_name = QB::query("SELECT ranking_name FROM category_link_with_ranking WHERE pid = $project_sel_f AND category_status = $p3_status_kk ORDER BY id DESC LIMIT 1")->get();
            $show_ranking_name = !empty($get_ranking_name) ? $get_ranking_name[0]->ranking_name : "{{ranking_name}}";
        }
    }

    if (($project_print_online_hold_status == 0 || $project_print_online_hold_status == 1 || 
         $project_print_online_hold_status == 2 || $project_print_online_hold_status == 3 || 
         $project_print_online_hold_status == 4) && $project_closed_status == 0) {
        $strMailContent = str_replace("{{closedcontent2}}", '', $strMailContent);
        $strMailContent = str_replace("{{closedcontent3}}", '', $strMailContent);
    } else {
        $strMailContent = str_replace("{{closedcontent2}}", $closed_client_2k, $strMailContent);
        $strMailContent = str_replace("{{closedcontent3}}", $closed_client_3k, $strMailContent);
    }
    
    $strMailContent = str_replace("{{closedcontent1}}", $closed_client_1k, $strMailContent);
    $strMailContent = str_replace("{{old_project_category}}", $old_status_name, $strMailContent);
    $strMailContent = str_replace("{{magazinename}}", $getmname, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink_new}}", $mnameurl_new, $strMailContent);
    $strMailContent = str_replace("{{oldmagazinewithlink}}", $oldmnameurl, $strMailContent);
    $strMailContent = str_replace("{{companypreviousprofile}}", $old_new_website_link, $strMailContent);

    if ($compny_id) {
        $check_rankkk = QB::query("SELECT `rank`, curl FROM master_companies WHERE cid = $compny_id AND `rank` IN (5,10,11)")->get();
        
        if (!empty($check_rankkk)) {
            $check_rankkk_curl = $check_rankkk[0]->curl;
            
            $check_traffic = QB::query("SELECT ttl_click, ttl_view FROM traffic_click_view_rank_details WHERE url = '$check_rankkk_curl' ORDER BY date(addeddate) DESC, ttl_click DESC LIMIT 1")->get();
            
            if (!empty($check_traffic)) {
                $get_traffic_click = $check_traffic[0]->ttl_click;
                $get_traffic_view = $check_traffic[0]->ttl_view;
                
                if ($get_traffic_click >= 60) {
                    $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                    $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
                } elseif ($get_traffic_click >= 30) {
                    $strMailContent = str_replace("{{traffic_click}}", $get_traffic_click, $strMailContent);
                    $strMailContent = str_replace("{{traffic_view}}", $get_traffic_view, $strMailContent);
                }
            }
        }
    }

    if (($magid == 1 || $magid == 49) && strpos($strMailContent, "{{casestudypara1}}") !== false && 
        $draft_name == 'Past Client' && $project_sel_f != 3092 && $project_sel_f != 2577) {
        $strMailContent = str_replace("{{casestudypara1}}", $caseStudyContent, $strMailContent);
        $strMailContent = str_replace("{{casestudypara2}}", $caseStudyContent2, $strMailContent);
    } else {
        $strMailContent = str_replace("{{casestudypara1}}", "", $strMailContent);
        $strMailContent = str_replace("{{casestudypara2}}", "", $strMailContent);
    }

    if ($compny_id) {
        $select_check_rank = QB::query("SELECT * FROM master_companies WHERE cid = $compny_id AND `rank` IN (10,11)")->get();
        $proinfo = QB::query("SELECT pro_info FROM projectinfo WHERE pid = $project_sel_f AND pro_info != '' AND pro_info IS NOT NULL")->get();
        
        if (!empty($select_check_rank)) {
            if (isset($old_mag) && !empty($old_mag)) {
                if ($add_magid != $old_mag) {
                    if (!empty($proinfo)) {
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

    $strMailContent = str_replace("{{info}}", $info_content, $strMailContent);
    $signature_new = str_replace("Canada", '', $signature_new);
    $signature_new = str_replace("Latin America", '', $signature_new);

    $get_sender_fname = QB::query("SELECT f_name, l_name FROM proposal_fname_details WHERE pid = $project_sel_f")->get();
    if (!empty($get_sender_fname)) {
        $sender_fname_k = $get_sender_fname[0]->f_name;
        $sender_lname_k = $get_sender_fname[0]->l_name;
    }

    if ($p3_status_kk) {
        $get_jobtitle = QB::query("SELECT jobtitle FROM job_title WHERE pid = $project_sel_f AND category = $p3_status_kk AND flag = 0")->get();
        $jobtitles = !empty($get_jobtitle) ? $get_jobtitle[0]->jobtitle : "{{jobtitles}}";
    }

    if (!empty($master_com_id)) {
        $getstates = QB::query("SELECT state FROM companies WHERE id = $master_com_id")->get();
        $states = !empty($getstates) ? $getstates[0]->state : "{{state}}";
    }

    if ($cntry == 'United States Of America' || $cntry == 'US' || $cntry == 'USA') {
        $cntry = 'United States Of America';
    }
    
    $profile_cost_kk = null;
    if ($cntry) {
        $check_profile_country = QB::query("SELECT profile_cost FROM companywise_cost WHERE country = '$cntry'")->get();
        if (!empty($check_profile_country)) {
            $profile_cost_kk = $check_profile_country[0]->profile_cost;
        }
    }

    if ((stripos($getmname, "Europe") !== false) || ($project_region_status == 3)) {
        $region_val = "Europe";
        $cost_cover_val = "9000 Euros";
        $cost_coy_val = "5000 Euros";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk Euros" : "3000 Euros";
    } elseif ((stripos($getmname, "Apac") !== false) || ($project_region_status == 2)) {
        $region_val = "APAC";
        $cost_cover_val = "9000 USD";
        $cost_coy_val = "5000 USD";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk USD" : "3000 USD";
    } elseif ((stripos($getmname, "Canada") !== false) || 
             ($project_region_status == 1 && $project_region_status2 == 1)) {
        $region_val = "Canada";
        $cost_cover_val = "15,000 CAD";
        $cost_coy_val = "5000 CAD";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk CAD" : "3000 CAD";
    } elseif ((stripos($getmname, "Latin America") !== false) || 
             ($project_region_status == 1 && $project_region_status2 == 2)) {
        $region_val = "Latin America";
        $cost_cover_val = "8000 USD";
        $cost_coy_val = "5000 USD";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk USD" : "2000 USD";
    } elseif (stripos($getmname, "MENA") !== false) {
        $region_val = "MENA";
        $cost_cover_val = "9000 USD";
        $cost_coy_val = "5000 USD";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk USD" : "3000 USD";
    } else {
        $region_val = "";
        $cost_cover_val = "$15,000";
        $cost_coy_val = "$5000";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk" : "$3000";
    }

    $check_uk_comp = QB::query("SELECT COUNT(cid) AS uk_cnt FROM master_companies WHERE cid = $compny_id AND (other_country IN ('United Kingdom', 'UK', 'United Kingdom (UK)') OR country IN ('United Kingdom', 'UK', 'United Kingdom (UK)'))")->get();
    if (!empty($check_uk_comp) && $check_uk_comp[0]->uk_cnt > 0) {
        $region_val = "UK";
        $cost_cover_val = "9000 GBP";
        $cost_coy_val = "5000 GBP";
        $cost_profille_val = $profile_cost_kk ? "$profile_cost_kk GBP" : "2500 GBP";
    }

    if (!empty($add_magid)) {
        $getsubscount = QB::query("SELECT subscriber_count FROM special_child_details WHERE magid = $add_magid ORDER BY id DESC LIMIT 1")->get();
        if (!empty($getsubscount)) {
            $subscriber_count = $getsubscount[0]->subscriber_count;
        }
    }

    $get_count_compay = QB::query("SELECT coy_flag, left_rec_id, right_rec_id, (SELECT primary_term FROM company_recognition_terms WHERE id = s.left_rec_id) AS left_name,(SELECT primary_term FROM company_recognition_terms WHERE id = s.right_rec_id) AS right_name FROM company_category_of_year s WHERE cid = $compny_id LIMIT 1")->get();
    if (!empty($get_count_compay)) {
        $left_term = $get_count_compay[0]->left_rec_id;
        $right_term = $get_count_compay[0]->right_rec_id;
        $left_name = $get_count_compay[0]->left_name;
        $right_name = $get_count_compay[0]->right_name;
        
        if ($left_term && $left_name != '[Blank]') {
            $left_name_value = $left_name . " ";
        } else {
            $left_name_value = "Top ";
        }
        if ($right_term && $right_name != '[Blank]') {
            $right_name_value = " " . $right_name;
        } else {
            $right_name_value = "";
        }
    }

    $check_partner_name = QB::query("SELECT partner_comp FROM startup_or_partner_details WHERE status = 1 AND cid = $compny_id AND partner_comp IS NOT NULL AND partner_comp != '' AND partner_comp != '.' LIMIT 1")->get();
    if (!empty($check_partner_name)) {
        $partner_namek = $check_partner_name[0]->partner_comp;
    }

    $category_array = ['Services', 'Solutions', 'Service', 'Solution', 'services', 'service', 'solutions', 'solution'];
    if (in_array($project_category, $category_array) || empty($project_category)) {
        $project_category = "{{project_category}}";
    }

    $strMailContent = str_replace("{{state}}", $states, $strMailContent);
    $strMailContent = str_replace("{{country}}", $cntry, $strMailContent);
    $strMailContent = str_replace("{{jobtitles}}", $jobtitles, $strMailContent);
    $strMailContent = str_replace("{{project_category}}", $project_category, $strMailContent);
    $strMailContent = str_replace("{{cost_para}}", $cost_word, $strMailContent);
    $strMailContent = str_replace("{{disclaimer}}", $disclaimer_word, $strMailContent);
    $strMailContent = str_replace("{{cost_cover}}", $cost_cover_val, $strMailContent);
    $strMailContent = str_replace("{{cost_COY}}", $cost_coy_val, $strMailContent);
    $strMailContent = str_replace("{{cost_profile}}", $cost_profille_val, $strMailContent);
    $strMailContent = str_replace("{{region}}", $region_val, $strMailContent);
    $strMailContent = str_replace("{{in_region}}", $in_region_val, $strMailContent);
    $strMailContent = str_replace("{{subscribercount}}", $subscriber_count, $strMailContent);
    $strMailContent = str_replace("{{partnername}}", $partner_namek, $strMailContent);
    $strMailContent = str_replace("{{top}}", $left_name_value, $strMailContent);
    $strMailContent = str_replace("{{company_of_the_year}}", $right_name_value, $strMailContent);
    $strMailContent = str_replace("{{in_country_state}}", $instate_country, $strMailContent);
    $strMailContent = str_replace("{{first_line}}", $first_word, $strMailContent);
    $strMailContent = str_replace("{{closedcontent1}}", $closed_client_1k, $strMailContent);
    $strMailContent = str_replace("{{old_project_category}}", $old_status_name, $strMailContent);
    $strMailContent = str_replace("{{magazinename}}", $getmname, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink}}", $mnameurl, $strMailContent);
    $strMailContent = str_replace("{{magazinewithlink_new}}", $mnameurl_new, $strMailContent);
    $strMailContent = str_replace("{{categorycustomization}}", $categorycustomization, $strMailContent);
    $strMailContent = str_replace("{{company_of_the_year}}", $company_category_oty, $strMailContent);
    $strMailContent = str_replace("{{general_category}}", $general_cat_name, $strMailContent);
    $strMailContent = str_replace("{{firstname}}", $first_name_kk, $strMailContent);
    $strMailContent = str_replace("{{lastname}}", $last_name_kk, $strMailContent);
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
    $strMailContent = str_replace("{{category}}", $cmp_status, $strMailContent);
    $strMailContent = str_replace("{{person_id_track}}", $add_person_id, $strMailContent);
    $strMailContent = str_replace("{{compose_id_track}}", $unique_id, $strMailContent);
    
    
    $strMailContent = str_replace("unsubscribe", "notifyus", $strMailContent);

    $unsubscribe_words = ['notifyus', 'optout', 'letusknow', 'unsubscribe', 'donotsend', 'informus', 'tellus', 'unjoin'];
    $receiver_email_enc = self::encrypt_decrypt('encrypt', $receiver_email_id);
    $project_enc = self::encrypt_decrypt('encrypt', $project_sel_f);
    $sender_enc = self::encrypt_decrypt('encrypt', $sender_email);
    $pname = self::get_project($project_sel_f);
    $sub_domain = str_replace(' ', '-', $pname);
    $person_track_spark = $add_person_id;
    $compose_track_spark = $unique_id;

    foreach ($unsubscribe_words as $word) {
        $unsubscribeLinkURL = self::getUnsubscribeLink_new($magid,$sender_domain,$sub_domain,$word,$this->signval_new);
        $unsubscribeLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_enc, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{project_idd}}", $project_enc, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{sender_email}}", $sender_enc, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{mail_type}}", $mail_type, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_email_id, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{project_iddd}}", $project_sel_f, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("{{unsub_word}}", $word, $unsubscribeLinkURL);
        $unsubscribeLinkURL = str_replace("amp;", '', $unsubscribeLinkURL);
        $strMailContent = str_replace($word, $unsubscribeLinkURL, $strMailContent);
    }

    $unsubscribeLinkOTurl = self::getUnsubscribeLink_kajolnew($magid,$sender_domain,$sub_domain, '', $this->signval_new
    );
    
    if ($unsubscribeLinkOTurl) {
        $unsubscribeLinkOTurl = str_replace("{{receiver_email_idd}}", $receiver_email_enc, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{project_idd}}", $project_enc, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{person_track_spark}}", $person_track_spark, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{compose_track_spark}}", $compose_track_spark, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{sender_email}}", $sender_enc, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{mail_type}}", $mail_type, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{receiver_email_iddd}}", $receiver_email_id, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{project_iddd}}", $project_sel_f, $unsubscribeLinkOTurl);
        $unsubscribeLinkOTurl = str_replace("{{unsub_word}}", "Unsubscribe", $unsubscribeLinkOTurl);
        $strMailContent = str_replace("{{unsub_OT}}", $unsubscribeLinkOTurl, $strMailContent);
    }

    $spamlinkLinkURL = self::getUnsubscribeLink_new($magid, $sender_domain, $sub_domain, '', $this->signval_new, 0, 1);
    $spamlinkLinkURL = str_replace("{{receiver_email_idd}}", $receiver_email_enc, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{receiver_email_iddd}}", $receiver_email_id, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_idd}}", $project_enc, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{project_iddd}}", $project_sel_f, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{person_track_spark}}", $person_track_spark, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{compose_track_spark}}", $compose_track_spark, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{sender_email}}", $sender_enc, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("{{mail_type}}", $mail_type, $spamlinkLinkURL);
    $spamlinkLinkURL = str_replace("amp;", '', $spamlinkLinkURL);
    $strMailContent = str_replace("{{spamlink}}", $spamlinkLinkURL, $strMailContent);

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
    $strSubject = str_replace("{{general_category}}", $general_cat_name, $strSubject);
    $strSubject = str_replace("{{ranking_name}}", $show_ranking_name, $strSubject);
    $strSubject = str_replace("{{country}}", $cntry, $strSubject);
    $strSubject = str_replace("{{region}}", $region_val, $strSubject);
    $strSubject = str_replace("{{state}}", $states, $strSubject);
    $strSubject = str_replace("{{category}}", $cmp_status, $strSubject);
    $strSubject = str_replace("{{project_category}}", $project_category, $strSubject);
    $strSubject = str_replace("{{company_of_the_year}}", $company_category_oty, $strSubject);
    $strSubject = str_replace("{{partnername}}", $partner_namek, $strSubject);
    $strSubject = str_replace("{{top}}", $left_name_value, $strSubject);
    $strSubject = str_replace("{{company_of_the_year}}", $right_name_value, $strSubject);

    return $strMailContent;
}
