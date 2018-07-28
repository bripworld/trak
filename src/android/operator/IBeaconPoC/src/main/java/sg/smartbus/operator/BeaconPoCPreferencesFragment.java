package sg.smartbus.operator;

import sg.smartbus.operator.R;
import android.os.Bundle;
import android.preference.PreferenceFragment;

public class BeaconPoCPreferencesFragment extends PreferenceFragment {

    @Override
    public void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	addPreferencesFromResource(R.xml.preferences);
    }

}
