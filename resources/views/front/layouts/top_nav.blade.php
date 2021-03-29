   <header>
        <div class="container">
                <a class="logo" href="{{ route('front.home') }}"><img src="{{asset('front/grocery/images/logo.png')}}" alt="Logo"></a>
<!-- <h5><a href="#" class="btn-primaryc plr-25"><b>SEE TODAYS MENU</b></a></h5> -->
                <div class="right-area">
                        <h6><div class="form-style-1" ><select id="language " class="language " name="language" style="background-color: #cfb62c;color: white;cursor: pointer;">
                                  <option  value="en" <?= $language == 'en' ? ' selected="selected"' : '';?>>{{ $language == 'en' ? 'English' : 'الإنجليزية' }}</option>
                                  <option  value="ar" <?= $language == 'ar' ? ' selected="selected"' : '';?>>{{ $language == 'ar' ?  'عربى' : 'Arabic' }}</option>
                        </select></div></h6>
                </div><!-- right-area -->

                <a class="menu-nav-icon" data-menu="#main-menu" href="#"><i class="ion-navicon"></i></a>

                <ul class="main-menu font-mountainsre" id="main-menu">
                        <li><a href="{{ route('front.home') }}">{{ $language == 'en' ? 'HOME' : 'الصفحة الرئيسية' }}</a></li>
                        
                </ul>

                <div class="clearfix"></div>
        </div><!-- container -->
</header>
<!-- <div class="form-style-1">
                        <select id="menu_id " class="mb-20 menu_id " name="menu_id" require>
                                  <option value="">Select</option>
                        </select>
                        </div> -->

                        