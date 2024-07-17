<footer id="footer" class="footer">

    <div class="footer-content">
        <div class="container">

            <div class="row g-5 d-flex justify-content-between">
                <div class="col-lg-4 ">
                    @foreach ($about as $item)
                        <h3 class="footer-heading">About ZenBlog</h3>
                        <p>{{ $item->short_description }}</p>
                        <p><a href="{{ route('about') }}" class="footer-link-more">Learn More</a></p>
                    @endforeach

                </div>
                <div class="col-6 col-lg-2">
                    <h3 class="footer-heading">Navigation</h3>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li><a href="{{ route('about') }}"><i class="bi bi-chevron-right"></i> About us</a></li>
                        <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h3 class="footer-heading">Recent Posts</h3>

                    <ul class="footer-links footer-blog-entry list-unstyled">
                        @for ($i = 0; $i < 5; $i++)
                            <li>
                                <a href="single-post.html" class="d-flex align-items-center">
                                    <div>
                                        <div class="post-meta d-block"><span
                                                class="date">{{ $posts[$i]->category_name }}</span> <span
                                                class="mx-1">&bullet;</span>
                                            <span>{{ $posts[$i]->created_at->format('d-m-Y') }}</span>
                                        </div>
                                        <span>{{ $posts[$i]->title }}</span>
                                    </div>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
