<?php
  public function suggestion_post(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        if (is_array($obj)) {
            $_POST = (array) $obj;
            $userData = $_POST;
        } else {
            $userData['user_id'] = $this->post('user_id');
            $userData['keyword'] = $this->post('keyword');
        }
        $this->form_validation->set_rules('user_id', 'user id', 'trim|required');
        $this->form_validation->set_rules('keyword', 'keyword', 'trim|required');
        if ($this->form_validation->run() === false) {
            if (form_error('user_id')) {
                $this->response(array(
                    'status' => "0",
                    'error' => strip_tags(form_error('user_id'))
                ), 400);
            }
            if (form_error('keyword')) {
                $this->response(array(
                    'status' => "0",
                    'error' => strip_tags(form_error('keyword'))
                ), 400);
            }
        } else {
            $user_id = $userData['user_id'];
            $keyword = $userData['keyword'];
            $lisArray = array();
            $lisArrayCreator = array();
            $lisArrayBlog = array();
            $lisArrayVideo = array();
            $getWritterIds = $this->getUsers($user_id, 'blogs');
            $getSql = "SELECT * FROM `users`
                WHERE `user_id` NOT IN('$user_id') AND users.name LIKE '".$keyword."%' AND `status` = '1' AND `user_id` IN('$getWritterIds') ORDER BY users.`name` ASC";
            $list = $this->Apimodel->fetch_all_join($getSql);
            if (!empty($list))
            {
                foreach ($list as $dataraw)
                {
                    $getWriterSQL = "SELECT * FROM `users` WHERE `user_id` = '".@$dataraw->user_id."' AND `status` = '1'";
                    $usrData = $this->Apimodel->fetch_single_join($getWriterSQL);
                    if(@$usrData->profile_image) {
                        $profilepic = base_url('uploads/profile_pictures/'.$usrData->profile_image);
                    } else {
                        $profilepic = base_url('uploads/noimage.jpg');
                    }
                    $lisArray[] = array(
                        'type' => 'writers',
                        'user_id' => @$dataraw->user_id,
                        'name' => @$usrData->name,
                        'profile_image' => @$profilepic
                    );
                }
            }
           $getCreatorIds = $this->getUsers($user_id, 'videos');
           $getCreatorSQL = "SELECT * FROM `users` WHERE `user_id` NOT IN('$user_id') AND users.name LIKE '".$keyword."%' AND `status` = '1' AND `user_id` IN('$getCreatorIds') ORDER BY users.`name` ASC";
            $listCreators = $this->Apimodel->fetch_all_join($getCreatorSQL);
            if (!empty($listCreators))
            {
                foreach ($listCreators as $value)
                {
                    $getCreatorInfoSQL = "SELECT * FROM `users` WHERE `user_id` = '".@$value->user_id."' AND `status` = '1'";
                    $usrDataCr = $this->Apimodel->fetch_single_join($getCreatorInfoSQL);
                    if(@$usrDataCr->profile_image) {
                        $crprofilepic = base_url('uploads/profile_pictures/'.$usrDataCr->profile_image);
                    } else {
                        $crprofilepic = base_url('uploads/noimage.jpg');
                    }
                    $lisArrayCreator[] = array(
                        'type' => 'creators',
                        'user_id' => @$value->user_id,
                        'name' => @$value->name,
                        'profile_image' => @$crprofilepic
                    );
                }
            }
            $getBlogQL = "SELECT * FROM `blogs` WHERE blogs.blog_title LIKE '".$keyword."%' AND `blog_status` = '1' ORDER BY blogs.`blog_title` ASC";
            $listBlogs = $this->Apimodel->fetch_all_join($getBlogQL);
            if (!empty($listBlogs))
            {
                foreach ($listBlogs as $value_b)
                {
                    if(@$value_b->blog_image)
                    {
                        $blogpic = base_url('uploads/blogs/'.$value_b->blog_image);
                    } else {
                        $blogpic = base_url('images/small.jpg');
                    }
                    $getInfoSQL = "SELECT * FROM `users` WHERE `user_id` = '".@$value_b->user_id."' AND `status` = '1'";
                    $usrDataUsr = $this->Apimodel->fetch_single_join($getInfoSQL);
                    if(@$usrDataUsr->profile_image) {
                        $bgprofilepic = base_url('uploads/profile_pictures/'.$usrDataUsr->profile_image);
                    } else {
                        $bgprofilepic = base_url('uploads/noimage.jpg');
                    }
                    $lisArrayBlog[] = array(
                        'type' => 'blogs',
                        'user_id' => @$value_b->user_id,
                        'name' => @$usrDataUsr->name,
                        'profile_image' => @$bgprofilepic,
                        'blog_id' => @$value_b->blog_id,
                        'blog_title' => @$value_b->blog_title,
                        'blog_image' => @$blogpic
                    );
                }
            }
            $getVideoSQL = "SELECT * FROM `videos` WHERE videos.video_title LIKE '".$keyword."%' AND `video_status` = '1' ORDER BY videos.`video_title` ASC";
            $listVideos = $this->Apimodel->fetch_all_join($getVideoSQL);
            if (!empty($listVideos)) {
                foreach ($listVideos as $value_v)
                {
                    if(@$value_v->video_cover_image)
                    {
                        $videoCoverpic = base_url('uploads/videos/video_cover_image/'.$value_v->video_cover_image);
                    } else {
                        $videoCoverpic = "";
                    }
                    if(@$value_v->video_file)
                    {
                        $videoFile = base_url('uploads/videos/'.$value_v->video_file);
                    } else {
                        $videoFile = "";
                    }
                    $getInfoSQL2 = "SELECT * FROM `users` WHERE `user_id` = '".@$value_v->user_id."' AND `status` = '1'";
                    $usrDataUsr2 = $this->Apimodel->fetch_single_join($getInfoSQL2);
                    if(@$usrDataUsr->profile_image) {
                        $bgprofilepic2 = base_url('uploads/profile_pictures/'.$usrDataUsr2->profile_image);
                    } else {
                        $bgprofilepic2 = base_url('uploads/noimage.jpg');
                    }
                    $lisArrayVideo[] = array(
                        'type' => 'videos',
                        'user_id' => @$value_v->user_id,
                        'name' => @$usrDataUsr->name,
                        'profile_image' => @$bgprofilepic2,
                        'video_id' => @$value_v->video_id,
                        'video_title' => @$value_v->video_title,
                        'blog_title' => @$value_v->blog_title,
                        'video_file' => @$videoFile,
                        'cover_image' => @$videoCoverpic,
                        'video_play_timing' => @$value_v->video_play_timing,
                        'screen_orientation'=>$value_v->screen_orientation,
                    );
                }
            }
            if (!empty($list) || !empty($listCreators) || !empty($listBlogs)) {
                $lisArray = $this->removeNull($lisArray);
                $lisArrayCreator = $this->removeNull($lisArrayCreator);
                $lisArrayBlog = $this->removeNull($lisArrayBlog);
                $lisArrayVideo = $this->removeNull($lisArrayVideo);
                $this->response([
                    'status' => "1",
                    'writerlist' => $lisArray,
                    'creatorlist' => $lisArrayCreator,
                    'bloglist' => $lisArrayBlog,
                    'videolist' => $lisArrayVideo
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'status' => "0",
                    'error' => 'No suggestion were found.'
                ), 400);
            }
        }
    }
?>