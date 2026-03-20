    <div class="page">

        <header class="top-bar">

            <div class="top-logo">
                <a href="/"><img src="{{ asset('images/homeDomeLogo.png') }}" alt="HomeDome logo"></a>
                <a href="/"><span class="top-logo-text">HomeDome</span></a>
            </div>



            <div class="top-search">
                <input id="searchInput" value="{{ request('query') }}" class="top-search-input" type="text" placeholder="Search for products...">
                <button id="searchButton" class="top-search-button">
                    Search
                </button>




                <details class="filter-dropdown">
                    <summary>
                        <i class="fa-solid fa-filter fa-2xs"></i>
                        <span>Filter</span>
                    </summary>

                    <div class="dropdown-content">
                        <form id="filterForm">

                            <h4>By Price</h4>
                            <label><input type="radio" name="price" value="0-50"> Under £50</label>
                            <label><input type="radio" name="price" value="50-100"> £50 - £100</label>
                            <label><input type="radio" name="price" value="100-200"> £100 - £200</label>
                            <label><input type="radio" name="price" value="200-300"> £200 - £300</label>
                            <label><input type="radio" name="price" value="300+"> £300+</label>

                            <h4>By Category</h4>
                            <label><input type="radio" name="category" value="Furniture"> Furniture</label>
                            <label><input type="radio" name="category" value="Appliances"> Appliances</label>
                            <label><input type="radio" name="category" value="Home Decor"> Home Decor</label>
                            <label><input type="radio" name="category" value="Kitchen Ware"> Kitchenware</label>
                            <label><input type="radio" name="category" value="Lighting"> Lighting</label>

                            <button type="submit" id="FilterButton">Apply</button>
                        </form>
                    </div>
                </details>

                <script>
                    document.getElementById('FilterButton').addEventListener('click', function(event) {

                        event.preventDefault();


                        const searchInput = document.getElementById('searchInput');
                        const priceEl = document.querySelector('input[name="price"]:checked');
                        const categoryEl = document.querySelector('input[name="category"]:checked');


                        const query = searchInput ? searchInput.value.trim() : '';
                        const priceVal = priceEl ? priceEl.value : '';
                        const catVal = categoryEl ? categoryEl.value : '';

                        if (!query && !priceVal && !catVal) {
                            alert('Please select a filter or enter a search term!');
                            return;
                        }


                        const params = new URLSearchParams();
                        if (query) params.append('query', query);
                        if (categoryEl) params.append('catVal', catVal);
                        if (priceEl) params.append('priceVal', priceVal);


                        window.location.href = `/filter?${params.toString()}`;
                    });
                </script>

                <script>
                    const searchInput = document.getElementById('searchInput');
                    const searchButton = document.getElementById('searchButton');

                    function performSearch() {
                        const query = searchInput.value.trim();
                        if (!query) {
                            alert('Please enter a search term!');
                            return;
                        } else {
                            window.location.href = `/search?query=${encodeURIComponent(query)}`;
                        }


                    }


                    searchButton.addEventListener('click', performSearch);


                    searchInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') performSearch();
                    });
                </script>



                <div class="top-icons">


                    @auth
                    <div class="account-menu">
                        <div class="icon-item account-trigger">
                            <i class="fa-solid fa-user"></i>
                            <span>Hello, {{ Auth::user()->name }}</span>
                        </div>

                        <div class="account-dropdown">
                            @if (Auth::user()->is_admin)
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fa-solid fa-user-pen"></i>
                                <span>My Profile</span>
                            </a>

                            <a class="dropdown-item" href="{{ route('pastOrders.index') }}">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Past Orders</span>
                            </a>

                            <a class="dropdown-item" href="/admin/create">
                                <i class="fa-solid fa-user-shield"></i>
                                <span>Create Admin Account</span>
                            </a>

                            <a class="dropdown-item" href="/admin/customers">
                                <i class="fa-solid fa-users"></i>
                                <span>Customer Management</span>
                            </a>

                            <a class="dropdown-item" href="/admin/change-password">
                                <i class="fa-solid fa-key"></i>
                                <span>Change Password</span>
                            </a>

                            <a class="dropdown-item" href="/admin/dashboard">
                                <i class="fa-solid fa-chart-line"></i>
                                <span>Dashboard</span>
                            </a>

                            <a class="dropdown-item" href="/admin/products">
                                <i class="fa-solid fa-boxes-stacked"></i>
                                <span>Inventory</span>
                            </a>

                            <a class="dropdown-item" href="/admin/orders">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>Orders</span>
                            </a>
                            @else

                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fa-solid fa-user-pen"></i>
                                <span>My Profile</span>
                            </a>

                            <a class="dropdown-item" href="{{ route('pastOrders.index') }}">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                                <span>Past Orders</span>
                            </a>

                            <a class="dropdown-item" href="/customer/change-password">
                                <i class="fa-solid fa-key"></i>
                                <span>Change password</span>
                            </a>

                            @endif

                            <div class="dropdown-divider"></div>

                            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="dropdown-item dropdown-item-btn">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth

                    @guest
                    <div class="account-menu">
                        <div class="icon-item account-trigger">
                            <i class="fa-solid fa-user"></i>
                            <span>Account</span>
                        </div>

                        <div class="account-dropdown">
                            <a class="dropdown-item" href="/login">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Login</span>
                            </a>

                            <a class="dropdown-item" href="/register">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </div>
                    </div>
                    @endguest

                    <a href="/wishlist" class="icon-item">
                        <i class="fa-regular fa-heart"></i>
                        <span>Wishlist</span>
                        <span class="icon-badge wishlist">{{ $wishlistCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('Basket') }}" class="icon-item">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Basket</span>
                        <span class="icon-badge basket">{{ $cartCount ?? 0 }}</span>
                    </a>
                </div>

        </header>

        <div class="category-bar">
            <a href="{{ route('category.show', 'furniture') }}">Furniture</a>
            <a href="{{ route('category.show', 'appliances') }}">Appliances</a>
            <a href="{{ route('category.show', 'home-decor') }}">Home Decor</a>
            <a href="{{ route('category.show', 'kitchen-ware') }}">Kitchenware</a>
            <a href="{{ route('category.show', 'lighting') }}">Lighting</a>

        </div>
    </div>