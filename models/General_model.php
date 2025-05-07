<?php defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getOne($table, $where)
    {
        $query = $this->db->get_where($table, $where);
        return $query->row();
    }
    public function get_where($table, $where) {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->row(); 
    }

    public function getOneOrderby($table, $where = '', $order_by = '', $order = '')
    {
        $this->db->select()->where($where);
        if (!empty($order_by)) {
            if (!empty($order)) {
                $this->db->order_by($order_by, $order);
            } else {
                $this->db->order_by($order_by, 'ASC');
            }
        }
        $query = $this->db->get($table);
        return $query->row();
    }

    public function getAll($table, $where = '')
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->result();
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        
        return $this->db->insert_id();
    }

    public function delete($table, $where)
    {
        return $this->db->where($where)->delete($table);
    }
    public function delete_record($id) {
        // // Delete dependent records first
        // $this->db->where('startup_id >=', $start_id);
        // // $this->db->where('startup_id <=', ;
        // $this->db->delete('startup_details');
        
        // Delete from startup_details
        $this->db->where('id >=', $start_id);
        // $this->db->where('id <=', $end_id);
        return $this->db->delete('attende_details');
    }
    

    public function get_startups(){
        $this->db->select('id,name,logo_src');
        $this->db->from('startup_details');
        $query = $this->db->get();
         return $query->result(); 
     } 

    public function update($table, $where, $data)
    {
        return $this->db->update($table, $data, $where);
        
        
    }

    public function update_batch($table, $data, $key)
    {
        return $this->db->update_batch($table, $data, $key);
    }

    public function insert_batch($table, $data)
    {
        return $this->db->insert_batch($table, $data);
    }

    public function delete_where_not_in($table, $ids, $where, $colunm = 'id')
    {
        $this->db->where($where);
        $this->db->where_not_in($colunm, $ids);
        $this->db->delete($table);
    }

    public function getCount($table, $where = '')
    {
        if (!empty($where)) {
            $query = $this->db->select()
                ->where($where)
                ->get($table);
        } else {
            $query = $this->db->select()
                ->get($table);
        }

        return $query->num_rows();
    }

    public function update_record($table = " ", $column = " ", $where = " ")
    {
        $this->db->where($where);
        return $this->db->update($table, $column);
    }

    public function get_startup_by_name($name)
    {
        $this->db->select('id');
        $this->db->from('startup_details');
        $this->db->where('name', $name);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_all_startup_logos()
    {
        $this->db->select('startup_details.*');
        $this->db->from('startup_details');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_attendee_logos()
    {
        $this->db->select('id, profile_image, name');
        $this->db->from('attende_details');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_startup_logo_path($startup_id, $local_path)
    {
        $this->db->where('id', $startup_id);
        return  $this->db->update('startup_details', array('logo-src' => $local_path));
    }
    public function update_attendee_logo_path($attende_id, $local_path)
    {
        $this->db->where('id', $attende_id);
        return  $this->db->update('attende_details', array('profile_image_download_path' => $local_path));
    }

    public function getStartup($limit = null, $offset = null)
    {
        $this->db->select('startup_details.*');
        $this->db->order_by('startup_details.name');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('startup_details');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getStartupFilter($limit = null, $offset = null, $search = "", $country = "", $type = "", $sector = "", $random_order = false)
    {
        $this->db->select('startup_details.*');
        $this->db->where('startup_details.isActive', 1);


        if ($random_order) {
            $this->db->order_by('RAND()');
        } else {
            $this->db->order_by('startup_details.name');
        }

        if ($search) {
            $this->db->like('startup_details.name', $search, 'both');
        }
        if ($country) {
            $this->db->where_in('startup_details.country', $country, 'both');
        }
        if ($type) {
            $this->db->where_in('startup_details.stage', $type, 'both');
        }
        if ($sector) {
            $this->db->where_in('startup_details.sector', $sector, 'both');
        }
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('startup_details');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function countStartup($search = null, $country = null, $type = null, $sector = null)
    {
        if (!empty($search)) {
            $this->db->like('startup_details.name', $search, 'both');
        }
        if (!empty($country)) {
            $this->db->where_in('startup_details.country', $country, 'both');
        }
        if (!empty($type)) {
            $this->db->where_in('startup_details.stage', $type, 'both');
        }
        if (!empty($sector)) {
            $this->db->where_in('startup_details.sector', $sector, 'both');
        }
        return $this->db->count_all_results('startup_details');
    }

    public function getAttendees($limit = null, $offset = null, $search = "", $type = "", $country = "", $sector = "", $expertise="", $learnabout="", $random_order = false)
    {
        $this->db->select('attende_details.*');
        $this->db->where('attende_details.isActive', 1);


        if ($random_order) {
            $this->db->order_by('RAND()');
        } else {
            $this->db->order_by('attende_details.name', 'ASC');
        }

        if ($search) {
            $this->db->like('attende_details.name', $search, 'both');
        }
        if (!empty($type)) {
            $this->db->where_in('attende_details.above_name', $type, 'both');
        }
        if (!empty($country) && count($country) > 0) {
            $this->db->group_start();
            foreach ($country as $key => $c) {
                if ($key == 0) {
                    $this->db->like('attende_details.country', $c, 'both');
                } else {
                    $this->db->or_like('attende_details.country', $c, 'both');
                }
            }
            $this->db->group_end();
        }
        if (!empty($sector)) {
            $this->db->where_in('attende_details.industry', $sector, 'both');
        }
        if (!empty($expertise)) {
            $this->db->join('expertise_tag', 'attende_details.id = expertise_tag.attende_id', 'left');
            $this->db->where_in('expertise_tag.expertise', $expertise);
        }
        if (!empty($learnabout)) {
            $this->db->join('learn_about_tag', 'attende_details.id = learn_about_tag.attende_id', 'left');
            $this->db->where_in('learn_about_tag.tag', $learnabout);
        }
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('attende_details');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function countAttendees($search = null, $type = null, $country = null, $sector = null, $expertise = null, $learnabout = null)
    {
        if (!empty($search)) {
            $this->db->like('attende_details.name', $search, 'both');
        }
        if (!empty($type)) {
            $this->db->where_in('attende_details.above_name', $type, 'both');
        }
        if (!empty($country) && count($country) > 0) {
            $this->db->group_start();
            foreach ($country as $key => $c) {
                if ($key == 0) {
                    $this->db->like('attende_details.country', $c, 'both');
                } else {
                    $this->db->or_like('attende_details.country', $c, 'both');
                }
            }
            $this->db->group_end();
        }
        if (!empty($sector)) {
            $this->db->where_in('attende_details.industry', $sector, 'both');
        }
    
        // Join expertise and learn_about tables
        if (!empty($expertise)) {
            $this->db->join('expertise_tag', 'attende_details.id = expertise_tag.attende_id');
            $this->db->where_in('expertise_tag.expertise', $expertise, 'both');
        }
    
        if (!empty($learnabout)) {
            $this->db->join('learn_about_tag', 'attende_details.id = learn_about_tag.attende_id');
            $this->db->where_in('learn_about_tag.tag', $learnabout, 'both');
        }
    
        return $this->db->get('attende_details')->num_rows();
    }
    
    public function getUniqueCountry()
    {
        $this->db->select('industry');
        $this->db->distinct();
        $this->db->from('attende_details');
        $query = $this->db->get();
        return $query->result_array();
    }

    

public function get_field($table, $field, $conditions) {
    $this->db->select($field);
    $this->db->from($table);
    $this->db->where($conditions);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row()->$field;
    } else {
        return null; // or return a default value
    }
}


public function get_icon_id_by_link($link) {
    $this->db->select('id');
    $this->db->from('social_icons');
    $this->db->where('name', $link);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id;
    } else {
        return false;
    }   
}
public function delete_profile($table, $id, $resetStartupId = false) {
    $this->db->set('isActive', 0);
    
    if ($resetStartupId) {
        $this->db->set('startup_id', 0);
    }

    $this->db->where('id', $id);
    $this->db->where('isActive', 1);
    $this->db->update($table);

    return $this->db->affected_rows() > 0;
}


public function get_icon_ids_by_names($names) {
    if (empty($names)) {
        return [];
    }

    $this->db->select('id, name');
    $this->db->from('social_icons');
    $this->db->where_in('name', $names);
    $query = $this->db->get();

    $icon_ids = [];
    foreach ($query->result() as $row) {
        $icon_ids[$row->name] = $row->id;
    }

    return $icon_ids;
}
public function getabove(){
    $this->db->distinct();
    $this->db->select('above_name');
    $this->db->where("above_name NOT REGEXP '(http|https|www)'"); // Adjust regex as needed
    $query = $this->db->get('attende_details');
    return $query->result();
    
}
public function getCountry($table)
    {
        $this->db->distinct();
        $this->db->select('country');
        $query = $this->db->get($table);
    
        return $query->result(); 
    }
public function getindustry($table) {
   
    $this->db->distinct();
    $this->db->select('industry');
    $query = $this->db->get($table);

    return $query->result(); 

}

public function getDistinctValues($table, $column) {
    $this->db->distinct();
    $this->db->select($column);
    $query = $this->db->get($table);

    return $query->result(); 
}
 public function get_attendee(){
    $this->db->select('id,name,profile_image_download_path,country');
    $this->db->from('attende_details');
    $query = $this->db->get();
     return $query->result(); 
 } 
 

public function count_all($table) {
    return $this->db->count_all($table);
}
public function get_all_events() {
    $this->db->order_by('Date', 'ASC');
    $query = $this->db->get('events'); 
    //echo $this->db->last_query();exit;
    return $query->result();
}
public function getdetails($table,$user_id) {
    $this->db->where('login_id !=', 0); 
    $this->db->where('login_id', $user_id); 
    $this->db->where('isActive', 1);
    $query = $this->db->get($table);
    return $query->row(); 
}
public function countFundings($search = null, $type = null,$country = null, $sector = null)
    {
        if (!empty($search)) {
            $this->db->like('fundings_details.name', $search, 'both');
        }
        if (!empty($country)) {
            $this->db->where_in('fundings_details.location', $country, 'both');
        }
        if (!empty($type)) {
            $this->db->where_in('fundings_details.stage', $type, 'both');
        }
        if (!empty($sector)) {
            for($i=0;$i<count($sector);$i++){
                $this->db->or_like('fundings_details.investment_focus_category', $sector[$i], 'both');
            }
        }
        return $this->db->count_all_results('fundings_details');
    }



    public function getFundingFilter($limit = null, $offset = null, $search = "", $type = "", $country = "", $sector  = "", $random_order = false)
    {
        $this->db->select('id, name, investment_focus_category,stage,location,components');
        if ($random_order) {
            $this->db->order_by('RAND()');
        } else {
            $this->db->order_by('fundings_details.name');
        }
        if ($search) {
            $this->db->like('fundings_details.name', $search, 'both');
        }
        if ($country) {
            $this->db->where_in('fundings_details.location', $country, 'both');
        }
        if ($type) {
            $this->db->where_in('fundings_details.stage', $type, 'both');
        }
        if ($sector) {
            //$this->db->where_in('fundings_details.investment_focus_category', $sector, 'both');
            for($i=0;$i<count($sector);$i++){
                $this->db->or_like('fundings_details.investment_focus_category', $sector[$i], 'both');
            }
        }
        

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('fundings_details');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function GetLocationFunding() {
        $this->db->distinct();
        $this->db->select('location');
        $locations_query = $this->db->get('fundings_details');
        $location_names = [];
        foreach ($locations_query->result() as $location) {
            if (!empty($location->location)) {
                $location_names[] = $location->location;
            }
        }
        sort($location_names);
        return $location_names;
    }

    public function GetSectorFunding() {
        $this->db->distinct();
        $this->db->select('investment_focus_category');
        $query = $this->db->get('fundings_details');
        $investment_focus_category_names = [];
        foreach ($query->result() as $investment_focus_category) {
            if (!empty($investment_focus_category->investment_focus_category)) {
                $categories = explode(',', $investment_focus_category->investment_focus_category);
                foreach ($categories as $category) {
                    $trimmed_category = trim($category);
                    if (!in_array($trimmed_category, $investment_focus_category_names)) {
                        $investment_focus_category_names[] = $trimmed_category;
                    }
                }
            }
        }
        sort($investment_focus_category_names);
        return $investment_focus_category_names;
    }

    public function GetFocusFunding() {
        $this->db->distinct();
        $this->db->select('stage');
        $query = $this->db->get('fundings_details');
        $stage_names = [];
        foreach ($query->result() as $stage) {
            if (!empty($stage->stage)) {
                $categories = explode(',', $stage->stage);
                foreach ($categories as $category) {
                    $trimmed_category = trim($category);
                    if (!empty($trimmed_category) && $trimmed_category !== '-') {
                        if (!in_array($trimmed_category, $stage_names)) {
                            $stage_names[] = $trimmed_category;
                        }
                    }
                }
            }
        }
        sort($stage_names);
        return $stage_names;
    }
    public function getFundingStartup_category($sector,$invest_sector){
        $this->db->select('id,name,details,investment_focus_category,location');
        $this->db->from('fundings_details');
        // if (!empty($invest_sector)) {
        //     $this->db->where_in('fundings_details.investment_focus_category', $invest_sector, 'both');
        // }
        $this->db->like('fundings_details.investment_focus_category', $sector, 'both');
        $this->db->limit("6");
        $query = $this->db->get();
        return $query->result();
        //echo $this->db->last_query();
        
    }
    public function countBuyers($search = null, $industry = null,$country = null, $sector = null)
    {
        if (!empty($country)) {
            $this->db->where_in('expand.cCountryName', $country, 'both');
        }
        if (!empty($industry) && count($industry) > 0) {
            $this->db->group_start();
            foreach ($industry as $key => $c) {
                if ($key == 0) {
                    $this->db->like('attende_details.industry', $c, 'both');
                } else {
                    $this->db->or_like('attende_details.industry', $c, 'both');
                }
            }
            $this->db->group_end();
        }
        $this->db->join('attende_details', 'attende_details.login_id = expand.nUserId AND attende_details.isActive=1', 'left');
        return $this->db->count_all_results('expand');
    }
    public function getbuyersFilter($limit = null, $offset = null, $search = "", $industry = "", $country = "", $sector  = "", $random_order = false)
    {
        $this->db->select('expand.nExpandId,expand.nUserId, expand.cProfileBio, expand.cSeeking,cHowwebuy,expand.cCountryName,cTimeline,cHowtoReach,cURL,cRequestIntro,cTCSProfile,attende_details.industry');
        if ($random_order) {
            $this->db->order_by('RAND()');
        } else {
            $this->db->order_by('attende_details.name');
        }
        if (!empty($country)) {
            $this->db->where_in('expand.cCountryName', $country, 'both');
        }
        if (!empty($industry) && count($industry) > 0) {
            $this->db->group_start();
            foreach ($industry as $key => $c) {
                if ($key == 0) {
                    $this->db->like('attende_details.industry', $c, 'both');
                } else {
                    $this->db->or_like('attende_details.industry', $c, 'both');
                }
            }
            $this->db->group_end();
        }
        

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $this->db->join('attende_details', 'attende_details.login_id = expand.nUserId AND attende_details.isActive=1', 'left');
        $query = $this->db->get('expand');
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function GetLocationBuyers() {
        $this->db->distinct();
        $this->db->select('cCountryName');
        $this->db->where("isActive",1);
        $locations_query = $this->db->get('expand');
//echo $this->db->last_query();exit;
        $location_names = [];
        foreach ($locations_query->result() as $location) {
            if (!empty($location->cCountryName)) {
                $location_names[] = $location->cCountryName;
            }
        }
        sort($location_names);
        //print_r($locations_query->result());
        return $location_names;
    }
    public function GetRelatedBuyers($country,$industry,$id){
        $this->db->distinct();
        $this->db->select('*');
        $this->db->where_not_in("login_id",$id);
        $this->db->where_in("country",$country);
        $this->db->where_in("industry",$industry);
        $this->db->where("isActive",1);
        $query = $this->db->get('attende_details');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}


