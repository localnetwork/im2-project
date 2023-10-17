<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');
    
    if (isset($_SESSION['user'])) {
        $user_email = $_SESSION['user']['email'];
        $user = new User();
        $userInfo = $user->getUserInfo($user_email);

        if(isset($userInfo['profile_picture'])) {
            $media_id = $userInfo['profile_picture']; 
            $media = $user->getMediaInfo($media_id); 
            $media_image = $media['uri']; 
        }else {
            $media_image = 'https://gravatar.com/avatar/5d87b85bbb213d818619d356c0a9d372?s=200&d=robohash&r=x'; 
        }

        if(isset($userInfo['profile_cover'])) {
            $cover_id = $userInfo['profile_cover']; 
            $cover = $user->getMediaInfo(1); 
            $cover_image = $cover['uri']; 
        }else {

        }



        echo "<div class='navigation relative'>
                <div class='cover-photo relative'>
                <div class='cover-container'>
        ";
        
        
        if(isset($cover_image)) {
            echo "<img class='cover-img' src='{$cover_image}' />"; 
        }else {
            echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" x="0" y="0" viewBox="0 0 298.73 298.73" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M264.959 9.35H33.787C15.153 9.35 0 24.498 0 43.154v212.461c0 18.634 15.153 33.766 33.787 33.766h231.171c18.634 0 33.771-15.132 33.771-33.766V43.154c.001-18.656-15.136-33.804-33.77-33.804zm-71.785 50.273c18.02 0 32.634 14.615 32.634 32.634s-14.615 32.634-32.634 32.634c-18.025 0-32.634-14.615-32.634-32.634s14.609-32.634 32.634-32.634zm61.189 198.526H49.039c-9.013 0-13.027-6.521-8.964-14.566l56.006-110.93c4.058-8.044 11.792-8.762 17.269-1.605l56.316 73.596c5.477 7.158 15.05 7.767 21.386 1.354l13.777-13.951c6.331-6.413 15.659-5.619 20.826 1.762l35.675 50.959c5.157 7.392 2.046 13.381-6.967 13.381z" style="" fill="#010002" data-original="#010002" class=""></path></g></svg>'; 
        }

        echo "
        </div>
        <div class='edit-cover'>
                        <a onclick='featureDisable()' href='#'>
                        <svg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='15' height='15' x='0' y='0' viewBox='0 0 471.04 471.04' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><path d='M414.72 112.64h-49.152l-27.136-40.96c-10.24-15.36-28.16-24.576-46.592-24.576H179.2c-18.432 0-36.352 9.216-46.592 24.576l-27.136 40.96H56.32A56.158 56.158 0 0 0 0 168.96v198.656a56.158 56.158 0 0 0 56.32 56.32h358.4a56.158 56.158 0 0 0 56.32-56.32V168.96a56.158 56.158 0 0 0-56.32-56.32zm-179.2 265.216c-70.144 0-126.976-56.832-126.976-126.976s56.832-126.464 126.976-126.464 126.976 56.832 126.976 126.976c0 69.632-56.832 126.464-126.976 126.464zM407.552 192h-22.528c-9.216-.512-16.384-8.192-15.872-17.408.512-8.704 7.168-15.36 15.872-15.872h20.48c9.216-.512 16.896 6.656 17.408 15.872.512 9.216-6.144 16.896-15.36 17.408z' fill='#ffffff' opacity='1' data-original='#000000' class=''></path><path d='M235.52 180.736c-38.912 0-70.656 31.744-70.656 70.656s31.744 70.144 70.656 70.144 70.656-31.744 70.656-70.656c0-38.912-31.744-70.144-70.656-70.144z' fill='#ffffff' opacity='1' data-original='#000000'></path></g></svg>
                            Edit Cover
                        </a>
                    </div>
                    <div class='user-photo'>
                        <img class='user-img' width='168' height='168' src='{$media_image}' />
                        <svg onclick='featureDisable()' xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='15' height='15' x='0' y='0' viewBox='0 0 471.04 471.04' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><path d='M414.72 112.64h-49.152l-27.136-40.96c-10.24-15.36-28.16-24.576-46.592-24.576H179.2c-18.432 0-36.352 9.216-46.592 24.576l-27.136 40.96H56.32A56.158 56.158 0 0 0 0 168.96v198.656a56.158 56.158 0 0 0 56.32 56.32h358.4a56.158 56.158 0 0 0 56.32-56.32V168.96a56.158 56.158 0 0 0-56.32-56.32zm-179.2 265.216c-70.144 0-126.976-56.832-126.976-126.976s56.832-126.464 126.976-126.464 126.976 56.832 126.976 126.976c0 69.632-56.832 126.464-126.976 126.464zM407.552 192h-22.528c-9.216-.512-16.384-8.192-15.872-17.408.512-8.704 7.168-15.36 15.872-15.872h20.48c9.216-.512 16.896 6.656 17.408 15.872.512 9.216-6.144 16.896-15.36 17.408z' fill='#ffffff' opacity='1' data-original='#000000' class=''></path><path d='M235.52 180.736c-38.912 0-70.656 31.744-70.656 70.656s31.744 70.144 70.656 70.144 70.656-31.744 70.656-70.656c0-38.912-31.744-70.144-70.656-70.144z' fill='#ffffff' opacity='1' data-original='#000000'></path></g></svg>
                    </div>
                </div>
                <div class='user-info'>
                    <h1>{$userInfo['first_name']} {$userInfo['last_name']}</h1>
                    <div class='user-actions'>
                        <a class='user-action-btn user-edit-profile' href='../users/update.php'>Edit Profile</a>
                    </div>
                </div>
        ";
        
        echo '</div>';
    }

?>