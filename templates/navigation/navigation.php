<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');
    
    if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];
        $user = new User();
        $userInfo = $user->getUserInfo($_SESSION['user_email']);

        if(isset($userInfo['profile_picture'])) {
            $media_id = $userInfo['profile_picture']; 
            $media = $user->getMediaInfo($media_id); 
            $media_image = $media['uri']; 
        }else {
            $media_image = 'https://gravatar.com/avatar/5d87b85bbb213d818619d356c0a9d372?s=200&d=robohash&r=x'; 
        }
        echo "<div class='navigation relative'>
                <div class='cover-photo relative'>
                    <img class='cover-img' src='https://scontent.fmnl26-2.fna.fbcdn.net/v/t39.30808-6/278713230_142375715000670_3235445839173398848_n.jpg?stp=dst-jpg_p640x640&_nc_cat=111&ccb=1-7&_nc_sid=5f2048&_nc_aid=0&_nc_eui2=AeE1JL90eRI4bqDh2O2qj1h-XuXE6TYrrGZe5cTpNiusZnhW1xjZJU39BUUgua1q3I1FokOXKvgwaiPRh2cdCqUF&_nc_ohc=BmGiJbB7hKEAX8F73pS&_nc_zt=23&_nc_ht=scontent.fmnl26-2.fna&oh=00_AfC9AuM447Dbj81LtlKMaKp4LZVj8itfCzMwKC2razop7w&oe=6531D97D' />
                    <div class='edit-cover'>
                        <a onclick='featureDisable()' href='#'><svg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='15' height='15' x='0' y='0' viewBox='0 0 471.04 471.04' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><path d='M414.72 112.64h-49.152l-27.136-40.96c-10.24-15.36-28.16-24.576-46.592-24.576H179.2c-18.432 0-36.352 9.216-46.592 24.576l-27.136 40.96H56.32A56.158 56.158 0 0 0 0 168.96v198.656a56.158 56.158 0 0 0 56.32 56.32h358.4a56.158 56.158 0 0 0 56.32-56.32V168.96a56.158 56.158 0 0 0-56.32-56.32zm-179.2 265.216c-70.144 0-126.976-56.832-126.976-126.976s56.832-126.464 126.976-126.464 126.976 56.832 126.976 126.976c0 69.632-56.832 126.464-126.976 126.464zM407.552 192h-22.528c-9.216-.512-16.384-8.192-15.872-17.408.512-8.704 7.168-15.36 15.872-15.872h20.48c9.216-.512 16.896 6.656 17.408 15.872.512 9.216-6.144 16.896-15.36 17.408z' fill='#ffffff' opacity='1' data-original='#000000' class=''></path><path d='M235.52 180.736c-38.912 0-70.656 31.744-70.656 70.656s31.744 70.144 70.656 70.144 70.656-31.744 70.656-70.656c0-38.912-31.744-70.144-70.656-70.144z' fill='#ffffff' opacity='1' data-original='#000000'></path></g></svg>
                            Edit Cover
                        </a>
                    </div>
                    <div class='user-photo'>
                        <img class='user-img' width='168' height='168' src='{$media_image}' />
                    </div>
                </div>
                <div class='user-info'>
                    <h1>{$userInfo['first_name']} {$userInfo['last_name']}</h1>
                    <div class='user-actions'>
                        <a class='user-action-btn user-edit-profile' onclick='featureDisable()' href='#'>Edit Profile</a>
                    </div>
                </div>
        ";
        
        echo '</div>';
    }

?>