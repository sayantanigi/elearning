    <div class="dashboard-content">

    <div class="container">
            <h4 class="dashboard-title">My Profile</h4>
            <div class="dashboard-profile">

                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">Registration Date</div>
                    <div class="dashboard-profile__content">
                        <p><?= date('d-M-Y \a\t h:i a', strtotime(@$myInfo->created))?></p>
                    </div>
                </div>
                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">First Name</div>
                    <div class="dashboard-profile__content">
                        <p><?= @$myInfo->firstName ?></p>
                    </div>
                </div>
                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">Last Name</div>
                    <div class="dashboard-profile__content">
                        <p><?= @$myInfo->lastName ?></p>
                    </div>
                </div>

                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">Email</div>
                    <div class="dashboard-profile__content">
                        <p><?= @$myInfo->email ?></p>
                    </div>
                </div>
                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">Phone Number</div>
                    <div class="dashboard-profile__content">
                        <p><?= @$myInfo->mobile ?></p>
                    </div>
                </div>
              
                <div class="dashboard-profile__item">
                    <div class="dashboard-profile__heading">Bio</div>
                    <div class="dashboard-profile__content">
                        <p><?= @$myInfo->descriptions ?></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>