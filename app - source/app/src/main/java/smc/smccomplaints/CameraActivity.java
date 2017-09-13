package smc.smccomplaints;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import com.backendless.Backendless;
import com.backendless.BackendlessUser;
import com.backendless.async.callback.AsyncCallback;
import com.backendless.exceptions.BackendlessFault;
import com.backendless.files.BackendlessFile;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

public class CameraActivity extends AppCompatActivity {

    ImageView take_picture;
    Bitmap imageBitmap;
    static final int REQUEST_IMAGE_CAPTURE = 1;
    Button send_complaint;
    BackendlessUser backendlessUser;
    Complaint complaint;
    EditText title, description;
    SharedPreferences sharedpreferences;
    public static final String MyPREFERENCES = "LoginObjectId";
    byte[] byteArray;
    Calendar c;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_camera);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        sharedpreferences = getSharedPreferences(MyPREFERENCES, Context.MODE_PRIVATE);

        take_picture = (ImageView) findViewById(R.id.takepicture);
        send_complaint = (Button) findViewById(R.id.sendcomplaint);
        title = (EditText) findViewById(R.id.subject);
        description = (EditText) findViewById(R.id.description);

        take_picture.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dispatchTakePictureIntent();
            }
        });

        send_complaint.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if ((title.getText().toString()).isEmpty() || (description.getText().toString()).isEmpty()) {
                    Toast.makeText(getApplicationContext(), "Title or description is empty.", Toast.LENGTH_LONG).show();
                }
                else if (checkGPS()) {
                    Toast.makeText(getApplicationContext(),"Turn on your GPS",Toast.LENGTH_LONG).show();
                    startActivity(new Intent(android.provider.Settings.ACTION_LOCATION_SOURCE_SETTINGS));
                } else {
                    Toast.makeText(getApplicationContext(),"Complaint Uploading...",Toast.LENGTH_LONG).show();
                    c = Calendar.getInstance();
                    String userID = HomeActivity.userToken;
                    if (userID != null) {
                        Backendless.UserService.findById(userID, new AsyncCallback<BackendlessUser>() {
                            @Override
                            public void handleResponse(BackendlessUser response) {
                                if (response != null) {
                                    Backendless.UserService.setCurrentUser(response);
                                    backendlessUser = response;
                                    complaint = new Complaint();
                                    complaint.setName((String) backendlessUser.getProperty("name"));
                                    complaint.setAddress(getAddress());
                                    complaint.setDescription(description.getText().toString());
                                    complaint.setTitle(title.getText().toString());
                                    complaint.setPhone((String) backendlessUser.getProperty("Phone"));
                                    Backendless.Files.Android.upload(imageBitmap, Bitmap.CompressFormat.PNG, 100, c.getTime().toString(), "mypics", new AsyncCallback<BackendlessFile>() {
                                        @Override
                                        public void handleResponse(final BackendlessFile backendlessFile) {
                                            complaint.setURL(backendlessFile.getFileURL());
                                            Backendless.Persistence.save(complaint, new AsyncCallback<Complaint>() {
                                                public void handleResponse(Complaint response) {
                                                    Toast.makeText(getApplicationContext(), "Successfully saved", Toast.LENGTH_LONG).show();
                                                }

                                                public void handleFault(BackendlessFault fault) {
                                                    Toast.makeText(getApplicationContext(), "Complaint:" + fault.getMessage(), Toast.LENGTH_LONG).show();
                                                }
                                            });
                                        }

                                        @Override
                                        public void handleFault(BackendlessFault backendlessFault) {
                                            Toast.makeText(getApplicationContext(), backendlessFault.getMessage(), Toast.LENGTH_SHORT).show();
                                        }
                                    });
                                }
                            }

                            @Override
                            public void handleFault(BackendlessFault fault) {
                            }
                        });
                    }
                }
            }
        });
    }

    private boolean checkGPS() {
        LocationManager mLocationManager = (LocationManager) getApplicationContext().getSystemService(Context.LOCATION_SERVICE);
        boolean gps_enabled = false;
        boolean network_enabled = false;

        try {
            gps_enabled = mLocationManager.isProviderEnabled(LocationManager.GPS_PROVIDER);
        } catch (Exception ignored) {
        }
        try {
            network_enabled = mLocationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
        } catch (Exception ignored) {
        }
        // notify user
        return !gps_enabled && !network_enabled;
    }

    private void dispatchTakePictureIntent() {
        Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        if (takePictureIntent.resolveActivity(getPackageManager()) != null) {
            startActivityForResult(takePictureIntent, REQUEST_IMAGE_CAPTURE);
        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == REQUEST_IMAGE_CAPTURE && resultCode == Activity.RESULT_OK) {
            Bundle extras = data.getExtras();
            imageBitmap = (Bitmap) extras.get("data");
            take_picture.setImageBitmap(imageBitmap);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_camera, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        if (id == R.id.action_logout) {
            SharedPreferences.Editor editor = sharedpreferences.edit();
            HomeActivity.userToken = null;
            editor.putString(HomeActivity.objectId, null);
            editor.apply();
            startActivity(new Intent(getApplicationContext(), HomeActivity.class));
            finish();
        }

        if (id == R.id.action_exit) {
            System.exit(0);
        }
        return super.onOptionsItemSelected(item);
    }

    private Location getLastKnownLocation() throws SecurityException {
        LocationManager mLocationManager = (LocationManager) getApplicationContext().getSystemService(Context.LOCATION_SERVICE);
        Location bestLocation = null;
        for (String provider : mLocationManager.getProviders(true)) {
            Location l = mLocationManager.getLastKnownLocation(provider);
            if (l != null && (bestLocation == null || l.getAccuracy() < bestLocation.getAccuracy())) {
                bestLocation = l;
            }
        }
        return bestLocation;
    }

    public String getAddress() {
        Location l = getLastKnownLocation();
        Geocoder geocoder;
        List<Address> addresses = null;
        geocoder = new Geocoder(this, Locale.getDefault());
        try {
            addresses = geocoder.getFromLocation(l.getLatitude(), l.getLongitude(), 1); // Here 1 represent max location result to returned, by documents it recommended 1 to 5
        } catch (IOException e) {
            e.printStackTrace();
        }
        assert addresses != null;
        String address = addresses.get(0).getAddressLine(0);
        String city = addresses.get(0).getLocality();
        String state = addresses.get(0).getAdminArea();
        String country = addresses.get(0).getCountryName();
        String postalCode = addresses.get(0).getPostalCode();
        String knownName = addresses.get(0).getFeatureName();
        return address + " " + city + " " + state + " " + country + " " + postalCode + " " + knownName;
    }

}
