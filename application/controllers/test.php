<?php
class Test extends MY_Frontend
{
    var $display = 3;
    var $service;
    var $subtype;
    var $us_state;
    var $us_city;
    var $zipcode;
    var $name;
    var $phone;
    var $company_name;
    var $ad_arr;
    var $keyword;
    var $data;
    var $one = true;
    var $two = true;
    var $three = true;
    function __construct() //this could also be called function User(). the way I do it here is a PHP5 constructor
    {
       parent::__construct();
       $this->data['text1'] = '';
       $this->data['link1'] = '';
       $this->data['text2'] = '';
       $this->data['link2'] = '';
       $this->data['text3'] = '';
       $this->data['link3'] = '';
       $this->data['service1'] = '';
       $this->data['service_link1'] = '';
       $this->data['service2'] = '';
       $this->data['service_link2'] = '';
    }
    public function index()
	 {
	   $this->load->model('user_model');
      $this->data['states'] = $this->user_model->getUS_State();
      $this->data['tot_st'] = $this->user_model->getNum_USStates();
      $this->data['services'] = $this->user_model->get_Service('', 'admin');
      $this->home();
    }
    public function home()
	 {
      $this->data['title'] = 'Snell Expert - Locate';
      $page_no = $this->uri->segment($this->uri->total_segments());
      // print 'uri_segment: ' . $this->uri->total_segments() . '<br>';
      $this->parse_url();
      if ($this->ad_arr == "")
         $this->ad_arr = 'ad_type,-1';
	   $this->data['banners'] = parent::get_banner($this->ad_arr);
      $this->data['main_content'] = 'frontend/locate_view';
      $this->load->view('template/frontend/content', $this->data);
      
    }
    public function result()
	 {
      $this->session->set_userdata('ads', '');
      $ad = '';
      $ad_for_scrollbar = '';
      $this->data['ad_zip'] = '';
      $this->data['ad_city'] = '';
      $this->data['ad_state'] = '';
      $this->data['ad_zip_heading'] = '';
      $this->data['ad_city_heading'] = '';
      $this->data['ad_state_heading'] = '';
      $this->data['title'] = 'Snell Expert - Search Result';
      $page_no = $this->uri->segment($this->uri->total_segments());
      $ad = $this->sponsor_ad('zipcode');
      if ($ad <> "")
      {
         $this->data['ad_zip_heading'] = str_replace('|', ', ', $ad) . ' Company';
         $ad = parent::get_banner('ad_type,5,zip,' . $ad, TRUE, TRUE);
         $this->data['ad_zip'] = $ad;
         $ad_for_scrollbar .= ',zip,' . $this->sponsor_ad('zipcode');
      }
      /* else
      {
         $ad = parent::get_banner('ad_type,2', TRUE, TRUE);
         $this->data['ad_zip'] = $ad;
      }  */
      $ad = $this->sponsor_ad('us-city');
      if ($ad <> "")
      {
         $this->data['ad_city_heading'] = ucwords(str_replace('|', ', ', $ad)) . ' Company';
         $ad = parent::get_banner('ad_type,4,LOWER(city),' . $ad, TRUE, TRUE);
         $this->data['ad_city'] = $ad;
         $ad_for_scrollbar .= ',LOWER(city),' . $this->sponsor_ad('us-city');
      }
      /* else
      {
         $ad = parent::get_banner('ad_type,2', TRUE, TRUE);
         $this->data['ad_city'] = $ad;
      }  */
      $ad = $this->sponsor_ad('us-state');
      if ($ad <> "")
      {
         if (strlen($ad) == "2")
         {
            $this->load->model('common_model');
   	      $ad_state_heading = $this->common_model->scalar("us_states","region",array("code" => $ad));
            $this->data['ad_state_heading'] = ucwords(str_replace('|', ', ', $ad_state_heading)) . ' Company';
         }
         else
            $this->data['ad_state_heading'] = ucwords(str_replace('|', ', ', $ad)) . ' Company';
         $ad = parent::get_banner('ad_type,3,LOWER(state),' . $ad, TRUE, TRUE);
         $this->data['ad_state'] = $ad;
         $ad_for_scrollbar .= ',LOWER(state),' . $this->sponsor_ad('us-state');
      }
      /* else
      {
         $ad = parent::get_banner('ad_type,2', TRUE, TRUE);
         $this->data['ad_state'] = $ad;
      }  */
      if ($ad_for_scrollbar <> "")
      {
         // $ad_for_scrollbar = substr($ad_for_scrollbar, 1) . ', OR (ad_type=2 and sponsor=0),1';
         $ad_for_scrollbar = 'ad_type,-1, OR ad_type=2,1';
         // print '$ad_for_scrollbar: ' . $ad_for_scrollbar . '<br>';
   	   $this->data['banners'] = parent::get_banner($ad_for_scrollbar);
   	   // print $this->db->last_query();
   	}
   	else
   	  $this->data['banners'] = parent::get_banner('ad_type,-1,ad_type=2');
      
      $this->parse_url();
	   $this->data['keyword'] = str_replace('|', ' ' , $this->keyword);
	   // $this->load->helper('cookie');
      $sql = $this->get_sql();
      $total_rows = $this->db->query($sql)->num_rows;
      $this->data['actual_count'] = $total_rows;
      /*
      $this->load->library('pagination');
      // print 'this url: ' . $this->uri->segment($this->uri->total_segments()) . '<br>';
      if (is_numeric($this->uri->segment($this->uri->total_segments())))
      {
         // print 'if part --> ' . base_url() .  $this->get_url() . ' :base_url<br>';
         $config['base_url'] = base_url() .  $this->get_url();
      }
      else
      {
         // print 'else part --> ' . base_url() .  $this->uri->uri_string();
         $config['base_url'] = base_url() .  $this->uri->uri_string();
      }
      $config['uri_segment'] = $this->uri->total_segments();
      $config['num_links'] = 4;
      $config['total_rows'] = $total_rows;
      $config['per_page'] = $display;
      $config['cur_tag_open'] = '<b> [';
      $config['cur_tag_close'] = '] </b>';
      $config['full_tag_open'] = '<span> ';
      $config['full_tag_close'] = ' </span>';
      $config['first_link'] = ' First ';
      $config['last_link'] = ' Last ';
      $config['last_tag_open'] = '<span> ';
      $config['last_tag_close'] = '</span> ';
      $config['next_link'] = ' >> ';
      $config['next_tag_open'] = '<span id="nextbutton" style="padding-left:5px;"> ';
      $config['next_tag_close'] = ' </span>';
      $config['prev_link'] = ' << ';
      $config['prev_tag_open'] = '<span id="prevbutton" style="padding-right:5px;"> ';
      $config['prev_tag_close'] = ' </span>';

      $this->pagination->initialize($config);*/
      if (($page_no == "1") or ($page_no == "") or ($page_no == "locate") or (!is_numeric($page_no)))
			$sql .=	" LIMIT	0, " . $this->display;
		else
			$sql .=	" LIMIT	" . $page_no . ", " . $this->display;
      // print 'sql: ' . $sql . '<br>';
      
      $this->load->model('common_model');
	   $this->data["users"] = $this->common_model->explicit($sql);
	   // $this->data["num_rows"] = '<b>' . count($this->data["users"]) . '</b> Record(s) of Total: <b>' . $total_rows . '</b>';

      $this->data['main_content'] = 'frontend/test_view';
      $this->load->view('template/frontend/content', $this->data);
      
    }
    function infinite_scrolling()
    {
      $this->parse_url();
      $page_no = $this->uri->segment($this->uri->total_segments());
      $sql = $this->get_sql();
      if (($page_no == "1") or ($page_no == "") or ($page_no == "locate") or (!is_numeric($page_no)))
         $sql .=	" LIMIT	0, " . $this->display;
      else
         $sql .=	" LIMIT	" . $page_no . ", " . $this->display;
      // print 'sql: ' . $sql . '<br>';

      $this->load->model('common_model');
      $this->data["users"] = $this->common_model->explicit($sql);
      // $this->data["num_rows"] = '<b>' . count($this->data["users"]) . '</b> Record(s) of Total: <b>' . $total_rows . '</b>';

      $main_content = 'frontend/user_list';
      $this->load->view($main_content, $this->data);
    }
    function get_url()
    {
       $url = '';
       $ts = ($this->uri->total_segments()-1);
       for ($i=1; $i <= $ts; $i++)
       {
         $url .= $this->uri->segment($i) . '/';
         // print $i . '-->' . $url . '<br>';
       }
       if ($url <> "")
         $url = substr($url, 0, (strlen($url)-1));
       return $url;
    }
    function parse_url()
    {
       $ts = $this->uri->total_segments();
       $this->load->helper('array');
       for ($i=0; $i <= $ts; $i++)
       {
          if (strstr($this->uri->segment($i), 'service'))
          {
             $this->service = str_replace('+', '|', str_replace('-service', '', $this->uri->segment($i)));
             $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->service . '</a>&nbsp;>&nbsp;';
             $this->update_heading($this->service, $this->uri->segment($i), "service");
             $this->data['service1'] = ucwords(str_replace('|', ' ', $this->service));
             $this->data['service_link1'] = $this->uri->segment($i);
          }
          if (strstr($this->uri->segment($i), 'sub-type'))
          {
            $this->subtype = str_replace('+', '|', str_replace('-sub-type', '', $this->uri->segment($i)));
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->subtype . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->subtype, $this->uri->segment($i), "subtype");
            $this->data['service2'] = ucwords(str_replace('|', ' ', $this->subtype));
            $this->data['service_link2'] = $this->uri->segment($i);
          }
          if (strstr($this->uri->segment($i), 'us-state'))
          {
            $this->us_state = str_replace('+', ' ', str_replace('-us-state', '', $this->uri->segment($i)));
            $this->ad_arr .= "state," . $this->us_state . ",";
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->us_state . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->us_state, $this->uri->segment($i), "usstate");
          }
            
          if (strstr($this->uri->segment($i), 'us-city'))
          {
            $this->us_city = str_replace('+', '|', str_replace('-us-city', '', $this->uri->segment($i)));
            $this->ad_arr .= "city," . $this->us_city . ",";
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->us_city . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->us_city, $this->uri->segment($i), "uscity");
          }            
          if (strstr($this->uri->segment($i), 'zipcode'))
          {
            $this->zipcode = str_replace('+', '|', str_replace('-zipcode', '', $this->uri->segment($i)));
            $this->ad_arr .= "zip," . $this->zipcode . ",";
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->zipcode . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->zipcode, $this->uri->segment($i), "zipcode");
          }            
          if (strstr($this->uri->segment($i), 'fullname'))
          {
            $this->name = str_replace('+', '|', str_replace('-fullname', '', $this->uri->segment($i)));
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->name . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->name, $this->uri->segment($i), "fullname");
          }
          if (strstr($this->uri->segment($i), 'phone'))
          {
            $this->phone = str_replace('-phone', '', $this->uri->segment($i));
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->phone . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->phone, $this->uri->segment($i), "phone");
          }
          if (strstr($this->uri->segment($i), 'company'))
          {
            $this->company_name = str_replace('+', '|', str_replace('-company', '', $this->uri->segment($i)));
            $this->keyword .= '<a href="/locate/index/' . $this->uri->segment($i) . '">' . $this->company_name . '</a>&nbsp;>&nbsp;';
            $this->update_heading($this->company_name, $this->uri->segment($i), "company");
          }            
       }
    }
    function sponsor_ad($type)
    {
       $val = '';
       $ts = $this->uri->total_segments();
       for ($i=0; $i <= $ts; $i++)
       {
          if (strstr($this->uri->segment($i), $type))
          {
             $val = str_replace('+', '|', str_replace('-' . $type, '', $this->uri->segment($i)));
             break;
          }
       }
       return $val;
    }
    function get_sql()
    {
         $sql = 'SELECT    u.id as uid,
                           u.business_logo,
                           u.name,
                           u.address,
                           u.city,
                           u.zip,
                           IF (u.approved=1, "<span style=\"color:#3e6b08; background-color:#FFFFFF;\">Snell Expert Approved</span>", "") as approved,
                           (SELECT us.region FROM us_states us WHERE us.code=u.state) as state,
                           u.email,
                           u.company_email,
                           u.phone1,
                           u.business_name,
                           CONCAT("<font style=\"font:Tahoma; font-size: 8; color: #000000\">Business Keyword: </font>", "<font color=#293243>", SUBSTRING_INDEX(business_keyword, ",", 5), "</font>") as business_keyword,
                           IF (LENGTH(u.business_desc) < 200,
                              u.business_desc,
                           CONCAT(SUBSTRING(u.business_desc, 1, 200),
                                 \'<span id="read_more\', u.id, \'_dot">… </span><span class="green1"><a id="read_more\', u.id, \'_href" href="javascript:void(0);" onclick="javascript: toggle_read_more(\', u.id, \', 1);">[READ MORE]</a></span>
                                 <span id="read_more\', u.id, \'" style="display:none">\',
                                 SUBSTRING(u.business_desc, 201, LENGTH(u.business_desc)),
                                 \'</span>
                                 <span class="green1">
                                    <a id="read_less\', u.id, \'_href"
                                       style="display:none"
                                       href="javascript:void(0);"            
                                       onclick="javascript: toggle_read_more(\', u.id, \', 0);">[READ LESS]</a></span>
                                 \')
                               ) as business_desc,
                           REPLACE(REPLACE(REPLACE(CONCAT(id, "/", name, "/", business_name, "/", state, "/", city, "/", zip, "/"), "&", ""), " ", "-"), ":", "-") as url
                 FROM      users u
                 WHERE     (!IFNULL(ban, 0))  AND
                           (active=1) AND
                           ((NOW() >= u.membership_start) AND (NOW() <= u.membership_end)) ';

         if ($this->service <> "")
           $sql .= ' AND u.id IN (SELECT  us.frn_user
                                  FROM    user_service us
                                  WHERE   us.frn_service IN (SELECT  s.id
                                                             FROM    service s
                                                             WHERE   s.name REGEXP "[[:<:]]' . $this->service . '[[:>:]]" )
                                  ) ';
         if ($this->subtype <> "")
           $sql .= ' AND u.id IN (SELECT  us.frn_user
                                  FROM    user_service us
                                  WHERE   us.frn_service IN (SELECT  s.frn_service
                                                             FROM    service_subtype s
                                                             WHERE   s.sub_type REGEXP "[[:<:]]' . $this->subtype . '[[:>:]]" )
                                  ) ';
         if ($this->us_state <> "")
         {
            if (strlen($this->us_state) == 2)
               $fld = ' = "' . strtoupper($this->us_state) . '" ';
            else
               $fld = ' REGEXP CONCAT("[[:<:]]", (SELECT us.code FROM us_states us WHERE us.region="' . $this->us_state . '"), "[[:>:]]") ';
           $sql .= ' AND ( IF(u.entire_nation <> "1", (u.id IN (SELECT  ua.frn_user
                                                                FROM    user_area ua
                                                                WHERE   ua.state ' . $fld . '
                                                                )
                                                    ),  1
                         	 )
                         ) ';
         }
         if ($this->us_city <> "")
           $sql .= ' AND ( IF(u.entire_nation <> "1", (u.id IN (SELECT  s.frn_user
                                                                FROM    user_area s
                                                                WHERE   s.city REGEXP "[[:<:]]' . $this->us_city . '[[:>:]]"
                                                               )
                                                    ),  1
                         	 )
                         ) ';
         if ($this->zipcode <> "")
           $sql .= ' AND ( IF(u.entire_nation <> 1, (u.id  IN (SELECT  s.frn_user
                                                               FROM    user_area s
                                                               WHERE   s.zip REGEXP "[[:<:]]' . $this->zipcode . '[[:>:]]"
                                                               )
                                                     ),  1
                         	 )
                         ) ';

         if ($this->name <> "")
           $sql .= ' AND (u.name REGEXP "[[:<:]]' . $this->name . '[[:>:]]") ';
         if ($this->phone <> "")
           $sql .= ' AND (
                           (u.phone1 = "' . $this->phone . '") OR
                           (u.phone2 = "' . $this->phone . '")
                         )';
         if ($this->company_name <> "")
           $sql .= ' AND (u.business_name REGEXP "[[:<:]]' . $this->company_name . '[[:>:]]") ';
         $sql .= ' ORDER BY u.name ';
      // print '<pre>' . $sql . '</pre>';
    	return $sql;
    }
    function update_heading($text, $heading, $field)
    {
       if ($this->one)
       {
         $short_state = str_replace('|', ' ', $text);
         $this->load->model('common_model');
         if ($field == 'usstate')
      	   $this->data["text1"] = $this->common_model->scalar("us_states","region",array("LOWER(code)=" => $short_state));
      	else
        	   $this->data["text1"] = urldecode($short_state);
         $this->data['link1'] = $heading;
         $this->one = false;
       }
       else if ($this->two)
       {
         $this->data['text2'] = urldecode(str_replace('|', ' ', $text));
         $this->data['link2'] = $heading;
         $this->two = false;
       }
       else if ($this->three)
       {
          $this->data['text3'] = urldecode(str_replace('|', ' ', $text));
          $this->data['link3'] = $heading;
          $this->three = false;
       }
    }
}
?>