<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');
    
    if (isset($_SESSION['user'])) {
        $user_email = $_SESSION['user']['email'];
        $user = new User();
        $userInfo = $user->getUserInfo($user_email);

        if(isset($userInfo['profile_picture'])) {
            $media_id = intval($userInfo['profile_picture']); 
            $media = $user->getMediaInfo($media_id); 
            $media_image = $media['uri']; 
        }else {
            $media_image = 'https://gravatar.com/avatar/5d87b85bbb213d818619d356c0a9d372?s=200&d=robohash&r=x'; 
        }
        echo "<header class='header'>
                <div class='logo'>
                    <a href='/'>
                    <svg viewBox='0 0 36 36' class='x1lliihq x1k90msu x2h7rmj x1qfuztq x5e5rjt' fill='currentColor' height='40' width='40'><path fill='#0866FF' d='M20.181 35.87C29.094 34.791 36 27.202 36 18c0-9.941-8.059-18-18-18S0 8.059 0 18c0 8.442 5.811 15.526 13.652 17.471L14 34h5.5l.681 1.87Z'></path><path fill='#ffffff' class='xe3v8dz' d='M13.651 35.471v-11.97H9.936V18h3.715v-2.37c0-6.127 2.772-8.964 8.784-8.964 1.138 0 3.103.223 3.91.446v4.983c-.425-.043-1.167-.065-2.081-.065-2.952 0-4.09 1.116-4.09 4.025V18h5.883l-1.008 5.5h-4.867v12.37a18.183 18.183 0 0 1-6.53-.399Z'></path></svg>
                    </a>
                </div>
                <div>
                    <div class='header-toggle'>
                        <img class='user-img' width='50' height='50' src='{$media_image}' />

                        <div class='dropdown'>
                            <div class='dropdown-item'>
                                <a href='../users/dashboard.php'>
                                <svg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 460.8 460.8' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><path d='M230.432 239.282c65.829 0 119.641-53.812 119.641-119.641C350.073 53.812 296.261 0 230.432 0s-119.64 53.812-119.64 119.641 53.812 119.641 119.64 119.641zM435.755 334.89c-3.135-7.837-7.314-15.151-12.016-21.943-24.033-35.527-61.126-59.037-102.922-64.784-5.224-.522-10.971.522-15.151 3.657-21.943 16.196-48.065 24.555-75.233 24.555s-53.29-8.359-75.233-24.555c-4.18-3.135-9.927-4.702-15.151-3.657-41.796 5.747-79.412 29.257-102.922 64.784-4.702 6.792-8.882 14.629-12.016 21.943-1.567 3.135-1.045 6.792.522 9.927 4.18 7.314 9.404 14.629 14.106 20.898 7.314 9.927 15.151 18.808 24.033 27.167 7.314 7.314 15.673 14.106 24.033 20.898 41.273 30.825 90.906 47.02 142.106 47.02s100.833-16.196 142.106-47.02c8.359-6.269 16.718-13.584 24.033-20.898 8.359-8.359 16.718-17.241 24.033-27.167 5.224-6.792 9.927-13.584 14.106-20.898 2.611-3.135 3.133-6.793 1.566-9.927z' fill='#000000' opacity='1' data-original='#000000' class=''></path></g></svg>
                                Profile</a>
                            </div>
                            <div class='dropdown-item'>
                                <a href='../users/logout.php'>
                                <svg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' width='512' height='512' x='0' y='0' viewBox='0 0 512.005 512' style='enable-background:new 0 0 512 512' xml:space='preserve' class=''><g><path d='M320 277.336c-11.797 0-21.332 9.559-21.332 21.332v85.336c0 11.754-9.559 21.332-21.336 21.332h-64v-320c0-18.219-11.605-34.496-29.055-40.555l-6.316-2.113h99.371c11.777 0 21.336 9.578 21.336 21.336v64c0 11.773 9.535 21.332 21.332 21.332s21.332-9.559 21.332-21.332v-64c0-35.285-28.715-64-64-64H48c-.812 0-1.492.363-2.281.469-1.028-.086-2.008-.47-3.051-.47C19.137.004 0 19.138 0 42.669v384c0 18.219 11.605 34.496 29.055 40.555L157.44 510.02c4.352 1.343 8.68 1.984 13.227 1.984 23.531 0 42.664-19.137 42.664-42.668v-21.332h64c35.285 0 64-28.715 64-64v-85.336c0-11.773-9.535-21.332-21.332-21.332zm0 0' fill='#000000' opacity='1' data-original='#000000' class=''></path><path d='m505.75 198.254-85.336-85.332a21.33 21.33 0 0 0-23.25-4.633C389.207 111.598 384 119.383 384 128.004v64h-85.332c-11.777 0-21.336 9.555-21.336 21.332 0 11.777 9.559 21.332 21.336 21.332H384v64c0 8.621 5.207 16.406 13.164 19.715a21.335 21.335 0 0 0 23.25-4.63l85.336-85.335c8.34-8.34 8.34-21.824 0-30.164zm0 0' fill='#000000' opacity='1' data-original='#000000' class=''></path></g></svg>
                                Logout</a>
                            </div>
                        </div> 
                    </div>
                </div>
        ";
        echo '</header>';
    }
?> 

<script type="text/javascript">
    var userImg = document.querySelector('.header-toggle');
    var dropdown = document.querySelector('.dropdown');

    userImg.addEventListener('click', function() {
        // Toggle the visibility of the dropdown element
        dropdown.classList.toggle('show');
    });

</script>