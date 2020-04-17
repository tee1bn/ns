<?php

use Illuminate\Database\Capsule\Manager as DB;
use Filters\Filters\UserFilter;


/**
 * this class is the default controller of our application,
 *
 */
class GenealogyController extends controller
{


    public function __construct()
    {

                if (! $this->admin()) {
                    $this->middleware('current_user')
                        ->mustbe_loggedin();
                }

    }


    /**
     * [showThisDownine handles the display of generations]
     * @param  [type] $user_id [user to display]
     * @param  [type] $type    [whether referred_by(placement structure)
     *  or introduced_by (enrolment strcuture)]
     * @return [type]          [description]
     */
    public function showThisDownine($user_id, $type)
    {
        $type_detail = [
            'introduced_by' => 'enrolment',
            'referred_by' => 'placement',
        ];
        $route = $type_detail[$type];


        $user_ = User::find($user_id);
        $recruiter = User::where('mlm_id', $user_->$type)->first()->username;
        $output = '';
        $output .= '<div  class="col-sm-1 col-xs-1   refer-people" align="center">
                          <a href="' . Config::domain() . '/genealogy/' . $route . '/' . $user_->username . '" data-toggle="tooltip" title="Upline:  ' . ucfirst($recruiter) . '">
                          ';

        $output .= ' <img class="img-responsive tree-img" src="' . Config::domain() . '/' . $user_->profilepic . '">';

        $output .= ' <p>' . ucfirst($user_->username) . "</p>       
                            </a>
                          </div>";

        return $output;
    }


    public function place_user($new_member = null, $placement_sponsor_id = null, $username = null)
    {
        echo "<pre>";

        $enrolee = User::find($new_member);
        $placement_sponsor = User::where('username', $username)->first();


        if (($new_member == null) || ($placement_sponsor_id == null)) {
            Session::putFlash('', 'Invalid Placement. Please check and try again.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");
            // return;

        }

        if ($enrolee->placed) {
            Session::putFlash('', 'Enrolee already placed.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");
            // return;

        }


        $new_member_level = $placement_sponsor->enroler_downline_level_of($new_member);
        $placement_sponsor_level = $placement_sponsor->enroler_downline_level_of($placement_sponsor_id);


        if (($new_member_level['present'] != 1) ||
            ($placement_sponsor_level['present'] != 1) ||
            ($new_member == $placement_sponsor_id)
        ) {

            Session::putFlash('', 'Invalid Placement. Please check and try again.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");

            return;
        }


        $placement = $enrolee->update([
            'referred_by' => $placement_sponsor_id,
            'placed' => 1,
        ]);

        if ($placement) {
            Session::putFlash('', 'Placed successfully.');
        }


        // Redirect::to('genealogy/placement');
        Redirect::to("admin/placement/$username");

    }


    public function enrolment($user_id = '')
    {
        $use = 'username';

        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            $user_id = $requested_user->id;

            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }

        }


        $this->view('auth/enrolment-structure', ['user_id' => $user_id]);

    }

    public function placement($user_id = '', $tree_key = 'placement', $requested_depth = null)
    {
        if (!in_array($tree_key, array_keys(User::$tree))) {
            // Session::putFlash("danger","Invalid Request");
            Redirect::to('genealogy/placement');
            die();

        }


        if (is_numeric($requested_depth)) {

            unset($_SESSION['requested_depth']);
        } else {
            $requested_depth = 1;
        }
        if (!isset($_SESSION['requested_depth'])) {

            $_SESSION['requested_depth'] = $requested_depth;
        }
        $levels = $_SESSION['requested_depth'];


        $use = 'username';

        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;

            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }

        }

        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];

        $this->view('auth/revamped-placement-structure', compact('user_id', 'tree', 'user_column', 'tree_key', 'levels'));


        // $this->view('auth/placement-structure', compact('user_id','tree','user_column','tree_key','levels'));

    }


    //to go up
    public function up()
    {
        echo "<pre>";
        print_r($_POST);
        $user = User::find($_POST['user_id']);
        $level_up = $_POST['level_up'];
        $tree_key = $_POST['tree_key'];

        $upline_mlm_id = $user->max_uplevel('placement')['mlm_ids'][$level_up];
        $upline = User::where('mlm_id', $upline_mlm_id)->first();


        $domain = Config::domain();
        $link = "$domain/genealogy/team_tree/$upline->username/$tree_key";
        Redirect::to($link);


    }

    public function last($position, $tree_key)
    {
        $auth = $this->auth();
        $last = $auth->all_downlines_at_position($position, $tree_key)->latest()->first();

        if ($last == null) {

            Session::putFlash("danger", "No Downline found");
            Redirect::back();
        }

        $domain = Config::domain();
        $link = "$domain/genealogy/team_tree/$last->username/$tree_key";
        Redirect::to($link);
    }


    public function showout()
    {
        extract($_POST);
        $domain = Config::domain();
        $link = "$domain/genealogy/placement/$username/$tree_key";
        Redirect::to($link);
    }


    private function users_matters($extra_sieve, $tree_key = 'placement')
    {


        $sieve = $_REQUEST;
        $sieve = array_merge($sieve, $extra_sieve);

        $query = $this->auth()->all_downlines_by_path($tree_key);


        // ->where('status', 1);  //in review
        $sieve = array_merge($sieve);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  UserFilter($sieve);

        $data = $query->Filter($filter)->count();

        $sql = $query->Filter($filter);

        $users = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        return compact('users', 'sieve', 'data', 'per_page');

    }


    public function search($query = null, $tree_key = 'placement')
    {

        $compact = $this->users_matters(['name' => $query], $tree_key);
        $users = $compact['users'];
        $line = "";
        foreach ($users as $key => $user) {
            $username = $user->username;
            $fullname = $user->fullname;
            $line .= "<option value='$username'> $fullname ($username)</option>";
        }

        header("content-type:application/json");
        echo json_encode(compact('line'));
    }

    public function determine_binary_point($member, $down_gen = [], $tree_key)
    {


        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];
        $user_point = $tree['point'];
        $width = $tree['width'];


        $available = range(0, ($width - 1));
        $taken = [];

        $down_gen = $down_gen ?? [];
        foreach ($down_gen as $key => $offspring) {

            if ($offspring[$user_column] == $member['mlm_id']) {
                $taken[] = $offspring[$user_point];
            }
        }

        $remaining = array_diff($available, $taken);


        return $remaining;

    }

    //this adds dummy user to postions not filled
    public function complete_downline($downlines, $tree_key = null, $levels = null)
    {


        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];
        $user_point = $tree['point'];
        $width = $tree['width'];


        $total_expection = 0;
        $exp = [];
        for ($i = 0; $i <= $levels; $i++) {
            $p = pow($width, $i);
            $total_expection += $p;
            $exp[$i] = $p;
        }

        $dummies = [];
        $uplines_with_deficient_members = [];

        foreach ($exp as $level => $no) { //check if all levels have expected no of peopele
            $downline_at_level = $downlines[$level] ?? [];

            if (count($downline_at_level) < $no) {


                $up_gen_level = $level - 1;
                $up_gen = $downlines[$up_gen_level] ?? [];    //determine the upper generation

                $down_gen_level = $level + 1;
                $down_gen = $downlines[$down_gen_level] ?? [];  //determine the lower generation

                ksort($up_gen);

                foreach ($up_gen as $key => $member) {
                    $remaining = $width - $member['no_of_direct_line']; //determine the remaining donwline(dummy) a user needs

                    $binary_points_left = $this->determine_binary_point($member, $down_gen, $tree_key); //determine the binarypoints left i.e positions left to fill

                    for ($i = 0; $i < $remaining; $i++) {
                        $mlm_id = -1 - count($dummies);  //generate a random mlm_id in the signed integer spectrun


                        if ($remaining < $width) {
                            $uplines_with_deficient_members[] = $member;  //get offsprings that will have mixed (both real and dummy users)


                            $binary_point = null;
                        } else {

                            $binary_point = $binary_points_left[0];
                            unset($binary_points_left[0]);
                            $binary_points_left = array_values($binary_points_left);
                        }

                        $dummy = [
                            'mlm_id' => $mlm_id,
                            $user_column => $member['mlm_id'],
                            'id' => $mlm_id,
                            'rank' => -1,
                            'username' => 'default',
                            $user_point => $binary_point,
                            'no_of_direct_line' => 0,
                        ];

                        $dummies[] = $dummy;
                        $downlines[$level][] = $dummy;
                    }

                }

            }


        }

        $flatten_downlines = array_flatten($downlines, 1);
        //fix deficient offsprings
        foreach ($uplines_with_deficient_members as $key => $deficient) {
            $mlm_id = $deficient['mlm_id'];
            $corrected_downlines = array_filter($flatten_downlines, function ($downline) use ($mlm_id, $user_column) {
                return $downline[$user_column] == $mlm_id;
            });

            $available = range(0, ($width - 1));
            $taken = [];


            foreach ($corrected_downlines as $key => $downline) { //get all the taken postions
                if ($downline['username'] != 'default') {
                    $taken[] = $downline[$user_point];
                }
            }

            $remaining = array_diff($available, $taken);
            $remaining = array_values($remaining);


            foreach ($corrected_downlines as $key => $downline) {
                if ($downline['username'] == 'default') {

                    $corrected_downlines[$key][$user_point] = $remaining[0];
                    unset($remaining[0]);
                    $remaining = array_values($remaining);
                }
            }


            foreach ($flatten_downlines as $key => $downline) {
                foreach ($corrected_downlines as $ckey => $cdownline) {

                    if (($downline['mlm_id'] == $cdownline['mlm_id']) && ($cdownline['username'] == 'default')) {
                        $flatten_downlines[$key] = $cdownline;
                    }
                }
            }

        }

        return $flatten_downlines;
    }

    public function fetch($user_id = '', $tree_key = 'placement', $requested_depth = null, $month =null)
    {
        if (!in_array($tree_key, array_keys(User::$tree))) {
            // Session::putFlash("danger","Invalid Request");
            Redirect::to('genealogy/placement');
            die();
        }

        if (is_numeric($requested_depth)) {

            unset($_SESSION['requested_depth']);
        } else {
            $requested_depth = 1;
        }
        if (!isset($_SESSION['requested_depth'])) {

            $_SESSION['requested_depth'] = $requested_depth;
        }
        $levels = $_SESSION['requested_depth'];
        $use = 'id';
        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;
            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }
        }
        $user = User::find($user_id);
        $downlines = $user->referred_members_downlines($levels, $tree_key);

        ksort($downlines);
        //we fill empty positions with dummy users
        // $flatten_downlines = $this->complete_downline($downlines, $tree_key, $levels);

        $flatten_downlines = array_flatten($downlines, 1);




        // print_r($flatten_downlines);
        $tree = User::$tree[$tree_key];
       $user_column = $tree['column'];

        $flatten_downlines = collect($flatten_downlines)->keyBy('mlm_id')->toArray();


        $re = $this->buildTree($flatten_downlines, $user->mlm_id, $user_column);

        //here we include the root in the tree
        $root = [
            'mlm_id' => $user->mlm_id,
            $user_column => $user->$user_column,
            'id' => $user->id,
            'rank' => $user->rank,
            'username' => $user->username,
            'no_of_direct_line' => 0
        ];
        $root['children'] = $re;


        $re = [];
        $re[$user->mlm_id] = $root;



        $list = ($this->buildList($re, $tree_key));
        
       


        $response = compact('list');
        header("content-type:application/json");
        echo json_encode($response);

    }


    //This returns the tree structure without the root()
    public function buildTree(array &$elements, $parentId = 0, $user_column)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element[$user_column] == $parentId) {
                $children = $this->buildTree($elements, $element['mlm_id'], $user_column);
                if ($children) {
                    $element['children'] = $children;
                }
                unset($elements[$element['mlm_id']]);
                $branch[$element['mlm_id']] = $element;
            }
        }
        return $branch;
    }

    public function get_detail($user_id, $tree_key)
    {

        $user = User::find($user_id);
echo         $view = $this->buildView('composed/mlm_detail', compact('user'));

        // header("content-type:application/json");
        // echo json_encode(compact('view'));
    }


    public function buildList($data, $tree_key)
    {
        $tree = '';


        $d_tree = User::$tree[$tree_key];
        $user_column = $d_tree['column'];
        // $user_point = $d_tree['point'];
        $width = $d_tree['width'];


        $i = 1;
        $domain = Config::domain();
        $icon = Config::domain() . "/template/default/app-assets/images/logo/packs";
        foreach ($data as $list_key => $node) {
            $username = $node['username'];
            $id = $node['id'];
            // $binary_point = $node[$user_point] ?? '';

            $mlm_id = $node['mlm_id'];

            $user = User::find($id);
            if ($user == null) {
                $view = "";

            } else {


                 $pack = $user->MembershipStatusDisplay['subscription']['payment_plan'];
                 $fa_status = $user->MembershipStatusDisplay['fa'];
                if ($pack == null) {

                    $image_src = "$domain/$user->profilepic";

                } else {
                    $pack_id = "";
                    $image_src = "$icon/$pack_id.png";
                    $background = $pack->Background;
                }


                $view = $this->buildView('composed/mlm_detail', compact('user', 'tree_key'), true);
            }


            if ($user == null) {
                $image_src = "$domain/template/default/app-assets/images/logo/Logo-head.png";

                $drop = <<<ELL
        <li>

        <span style="border:0px !important; padding-bottom: 10px;">
        <img src="$image_src" style="background: #0000007a;padding: 4px; border-radius: 70%;height: 55px; object-fit:contain;"><br>
        </span>
          
ELL;     

}else{

        $drop = <<<ELM
        <li>
                <div class="dropdown" style="padding:0px;">

        <span  class="dropdown-toggl text-white" data-toggle="dropdow" style="background:$background; border: 1px solid $background !important;padding-bottom: 0px;padding-top: 0px;">
        <a style="position: absolute;top: -20px;border: none;right: -14px;font-size:20px;">$fa_status</a>
        <b style="text-transform:capitalize;">$user->NameInitials </b>

        </span>
          <div class="dropdown-menu" style="padding:10px; border-radius:5px;" aria-labelledby="dropdownMenuButton$i">
            $view

            <a class="text-primary" href="$domain/genealogy/team_tree/$user->username/placement/2" style="font-size:12px; margin-left:30px;">See Tree</a>

          </div>
        </div>

ELM;     

}

        $tree .= $drop;


            if (isset($node['children'])) {
                    //ensures users are displayed in theier right leg
/*
                    array_multisort(
                                    array_column($node['children'], $user_point), SORT_ASC,
                                    $node['children']);*/
                
                $tree.= "<ul>";
                $tree.= $this->buildList($node['children'], $tree_key);
                $tree.= "</ul>";
            }

        $tree.="</li>";
        unset($data[$list_key]);
        $i++;
    }

    return $tree;
}















    public function team_tree($user_id = '')
    {

        $auth = $this->auth();
        $use = 'username';

        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $auth->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;

            if ($requested_user == null) {
                if ($auth) {
                    $user_id = User::where('username', $auth->username)->first()->id;
                }
            }

        }


        //perpare the dates range
        $dates = [];
        for ($i = 1; $i <= 9; $i++) {
          $dates[] = date('Y-n', strtotime("-$i month"));
        }


        $direct_sales_agent = $auth->all_downlines_by_path()
        ->where('referred_by', $auth->mlm_id)
        ->select(DB::raw('concat(year(created_at),"-", month(created_at) )AS year_month_date_field'), DB::raw('count(*) as total'))
        ->groupBy('year_month_date_field')->get()->keyBy('year_month_date_field');
        ;

        $sales_agent = $auth->all_downlines_by_path()
        ->select(DB::raw('concat(year(created_at),"-", month(created_at) )AS year_month_date_field'), DB::raw('count(*) as total'))
        ->groupBy('year_month_date_field')->get()->keyBy('year_month_date_field');
        ;

        krsort($dates);
   
        $tree_key = 'placement';

        $this->view('auth/team_tree', compact('user_id', 'direct_sales_agent', 'sales_agent','dates','tree_key'));

    }


    public function placement_list($username = null, $level_of_referral = 1)
    {
        $user = User::where('username', $username)->first();

        if ($user == null) {
            if ($this->auth()) {
                $user = User::where('username', $this->auth()->username)->first();
            }
        }


        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 500;

        $list = User::referred_members_downlines_paginated($user->id, $level_of_referral, $per_page, $page);

        $this->view('auth/placement-structure-list', compact('list', 'user', 'per_page', 'level_of_referral'));

    }


    public function team($username = null, $level_of_referral = 1)
    {
        $user = User::where('username', $username)->first();

        $auth = $this->auth();

        if ($user == null) {
            if ($auth) {
                $user = User::where('username', $auth->username)->first();
            }
        }


        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 500;

        $list = User::referred_members_downlines_paginated($user->id, $level_of_referral, $per_page, $page);
        $downlines_ids = $list['list']->pluck('mlm_id')->toArray();
        $no = User::whereIn('referred_by', $downlines_ids)
            ->select(DB::raw('count(*) as no_of_direct_lines'), 'referred_by')
            ->groupBy('referred_by')
            ->get()
            ->keyBy('referred_by')
        ;


        $note = MIS::filter_note(count($list['list']) , $list['data'], $list['total'],  $list['sieve'], 1);



        $this->view('auth/team', compact('list', 'user', 'per_page', 'note','level_of_referral','no'));

    }


}


?>