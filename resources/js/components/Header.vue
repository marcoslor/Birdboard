<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="flex justify-between items-center py-4">
                <h1>
                    <a class="navbar-brand" href="/">
                        Birdboard
                    </a>
                </h1>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link" href=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle"
                           data-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre>
                            USERNAME <span class="caret"></span>
                        </a>

                        <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/logout"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            </a>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
  export default {
    name: 'header',
    props: {},
  };
</script>
