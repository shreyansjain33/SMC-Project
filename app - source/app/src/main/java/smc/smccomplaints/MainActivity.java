package smc.smccomplaints;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.backendless.Backendless;
import com.backendless.BackendlessUser;
import com.backendless.async.callback.AsyncCallback;
import com.backendless.async.callback.BackendlessCallback;
import com.backendless.exceptions.BackendlessFault;

public class MainActivity extends AppCompatActivity {

    EditText name_, email_, phone_, password_;
    Button register;
    BackendlessUser backendlessUser;
    SharedPreferences sharedpreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        name_ = (EditText) findViewById(R.id.name);
        email_ = (EditText) findViewById(R.id.email);
        phone_ = (EditText) findViewById(R.id.phonenumber);
        password_ = (EditText) findViewById(R.id.password);
        register = (Button) findViewById(R.id.register);

        sharedpreferences = getSharedPreferences(HomeActivity.MyPREFERENCES, Context.MODE_PRIVATE);

        register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Toast.makeText(getApplicationContext(), "Please wait... You are being registered... :)", Toast.LENGTH_LONG).show();
                backendlessUser = new BackendlessUser();
                backendlessUser.setEmail(email_.getText().toString());
                backendlessUser.setPassword(password_.getText().toString());
                backendlessUser.setProperty("Phone", phone_.getText().toString());
                backendlessUser.setProperty("Name", name_.getText().toString());

                Backendless.UserService.register(backendlessUser, new BackendlessCallback<BackendlessUser>() {
                    @Override
                    public void handleResponse(BackendlessUser backendlessUser) {

                        Backendless.UserService.login(email_.getText().toString(), password_.getText().toString(), new AsyncCallback<BackendlessUser>() {
                            public void handleResponse(BackendlessUser user) {
                                SharedPreferences.Editor editor = sharedpreferences.edit();
                                editor.putString(HomeActivity.objectId, user.getObjectId());
                                editor.apply();
                                HomeActivity.userToken = user.getObjectId();
                                startActivity(new Intent(getApplicationContext(), CameraActivity.class));
                                finish();
                            }

                            public void handleFault(BackendlessFault fault) {
                                // login failed, to get the error code call fault.getCode()
                            }
                        }, true);

                    }
                });
            }
        });

    }
}
