<!--A registration form to register a new user on the site-->
<div class="p-5 mb-4 rounded-3">
    <div class="container">
        <h1 class="display-5 fw-bold">Sign In</h1>
        <p class="col-md-8 fs-4">First time here? Simply fill in all the fields and a new account will be created here</p>
        <form name="registrationForm" onsubmit="return validateForm()" method="post" action="signin.php">
            <!--            Here we define a couple fields to be entered when registering a new user on the site-->
            <div class="mb-3">
                <label for="registerFieldUsername" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="registerFieldUsername"
                       aria-describedby="searchFieldNameHelp">
            </div>
            <div class="mb-3">
                <label for="registerFieldPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="registerFieldPassword"
                       aria-describedby="searchFieldNameHelp">
            </div>
            <div class="mb-3">
                <label for="registerFieldEmail" class="form-label">Email Address (For Registration Only)</label>
                <input type="email" class="form-control" name="email" id="registerFieldEmail" aria-describedby="searchFieldNameHelp">
            </div>
            <div class="mb-3">
                <input class="registerFieldCheckbox" id="checkbox" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    I've read and agree the terms & conditions of Where Go Eat
                </label>
            </div>
            <!-- Javascript form validation-->
            <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
        </form>
    </div>
</div>