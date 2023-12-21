@php(Theme::layout('default'))

<div class="container">
    <div style="margin: 40px 0;">
        <h4 style="color: #f00; margin-bottom: 15px;">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Admin -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin -> Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;direction: ltr;">
                <div>[simple-slider key="home-slider"][/simple-slider]</div>
                <div>[check-availability-form][/check-availability-form]</div>
                <div>[about-us title="Most Safe & Rated Hotel In London." subtitle="About Us" description="At About Us, we take pride in offering the most secure and top-rated hotels in London. Your safety and comfort are our priorities, which is why our meticulous selection process ensures each hotel meets stringent quality standards. Whether you’re visiting for business or leisure, trust us to provide you with a stay that combines the utmost security and exceptional service.<br> <br>Experience London like never before with our curated list of accommodations that boast prime locations and unmatched safety measures. From charming boutique hotels to Luxuryous city-center options, we’ve done the groundwork to present you with a variety of choices that guarantee a worry-free stay. Choose About Us for a memorable trip enriched with both the allure of London." highlights="Discover the epitome of safe haven in our top-rated London hotels.; Immerse yourself in the heart of London’s charm.; Experience the perfect blend of luxury and comfort." style="style-1" button_label="DISCOVER MORE" button_url="/about-us" signature_image="general/signature.png" signature_author="Vincent Smith" top_left_image="services/about-img-02.png" bottom_right_image="services/about-img-03.png" floating_right_image="backgrounds/an-img-02.png"][/about-us]</div>
                <div>[featured-amenities title="The Hotel" subtitle="Explore" description="Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel" background_color="#F7F5F1" background_image="/backgrounds/an-img-01.png" amenity_ids="1,2,3,4,5,6"][/featured-amenities]</div>
                <div>[featured-rooms title="Rooms & Suites" subtitle="The Pleasure Of Luxury" description="Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel" room_ids="2,3,4,6,7"][/featured-rooms]</div>
                <div>[feature-area title="Pearl Of The Adriatic." subtitle="Luxury Hotel & Resort" description="Vestibulum non ornare nunc. Maecenas a metus in est iaculis pretium. Aliquam ullamcorper nibh lacus, ac suscipit ipsum consequat porttitor.Aenean vehicula ligula eu rhoncus porttitor. Duis vel lacinia quam. Nunc rutrum porta ex, in imperdiet tortor feugiat at. Cras finibus laoreet felis et hendrerit. Integer ligula lorem, finibus vitae lorem at, egestas consectetur urna. Integer id ultricies elit. Maecenas sodales nibh, quis posuere felis. In commodo mi lectus venenatis metus eget fringilla. Suspendisse varius ante eget." image="general/feature.png" background_image="backgrounds/an-img-02.png" button_primary_label="Discover More" button_primary_url="/contact-us" background_color="#F7F5F1"][/feature-area]</div>
                <div>[pricing title="Extra Services" subtitle="Best Prices" description="Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel Cras finibus laoreet felis et hendrerit. Integer ligula lorem, finibus vitae lorem at, egestas consectetur urna. Integer id ultricies elit. Maecenas sodales nibh, quis posuere felis. In commodo mi lectus venenatis metus eget fringilla. Suspendisse varius ante eget." background_image_1="backgrounds/an-img-01.png" background_image_2="backgrounds/an-img-02.png" quantity="2" title_1="Room cleaning" description_1="Perfect for early-stage startups" price_1="$39.99" duration_1="Monthly" feature_list_1="Hotel quis justo at lorem, Fusce sodales urna et tempus, Vestibulum blandit lorem quis" button_label_1="Get Started" button_url_1="/contact-us" title_2="Drinks included" description_2="Perfect for early-stage startups" price_2="$59.99" duration_2="Monthly" feature_list_2="Hotel quis justo at lorem, Fusce sodales urna et tempus, Vestibulum blandit lorem quis" button_label_2="Get Started " button_url_2="/contact-us"][/pricing]</div>
                <div>[booking-form title="Book A Room" subtitle="Make Appointment" image="general/booking-img.png" background_image="backgrounds/an-img-01.png" button_primary_label="Book Table Now" button_primary_url="/contact-us" style="style-2"][/booking-form]</div>
                <div>[intro-video title="Take A Tour Of Luxury" youtube_url="https://www.youtube.com/watch?v=ldusxyoq0Y8" background_image="general/video-bg.png"][/intro-video]</div>
                <div>[testimonials title="What Our Clients Says" subtitle="Testimonial" description="Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel" background_image="/backgrounds/testimonial-bg.png" testimonial_ids="1,2,3"][/testimonials]</div>
                <div>[news title="Latest Blog & News" subtitle="Our Blog" description="Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel" background_image="backgrounds/an-img-07.png" type="featured" limit="3"][/news]</div>
                <div>[brands background_color="#F7F5F1" quantity="6" name_1="Ersintat" image_1="brands/logo-1.png" link_1="https://ersintat.com" name_2="Techradar" image_2="brands/logo-2.png" link_2="https://techradar.com" name_3="Turbologo" image_3="brands/logo-3.png" link_3="https://turbologo.com" name_4="Thepeer" image_4="brands/logo-4.png" link_4="https://thepeer.com" name_5="Techi" image_5="brands/logo-5.png" link_5="http://techi.com" name_6="Grapik" image_6="brands/logo-6.png" link_6="https://grapk.com"][/brands]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <p><strong>3. Then go to Admin -> Appearance -> Theme options -> Page to set your homepage.</strong></p>
    </div>
</div>