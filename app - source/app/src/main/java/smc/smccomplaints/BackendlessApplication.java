package smc.smccomplaints;

import android.app.Application;
import com.backendless.Backendless;

public class BackendlessApplication extends Application{

    private static final String YOUR_APP_ID ="F4B1929D-3AB7-5B78-FF7C-9B89DF8C0300" ;
    private static final String YOUR_SECRET_KEY ="5E8F23FC-5A94-FFC0-FFDA-F4411F3F4700" ;

    @Override
    public void onCreate() {
        super.onCreate();

        String appVersion = "v1";
        Backendless.initApp(this, YOUR_APP_ID, YOUR_SECRET_KEY, appVersion);


    }
}
