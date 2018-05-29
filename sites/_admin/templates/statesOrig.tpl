<select name="{$sel_name}" {if $sel_id}id="{$sel_id}"{/if} {if $sel_class}class={$sel_class}{/if} {if $ro} DISABLED{/if}>
    <option value="0" selected="selected">Select...</option>
	<optgroup label="United States">
    <option value="US_AL" {if $sel_state=='US_AL'}SELECTED{/if}>Alabama</option>
    <option value="US_AK" {if $sel_state=='US_AK'}SELECTED{/if}>Alaska</option>
    <option value="US_AZ" {if $sel_state=='US_AZ'}SELECTED{/if}>Arizona</option>
    <option value="US_AR" {if $sel_state=='US_AR'}SELECTED{/if}>Arkansas</option>
    <option value="US_CA" {if $sel_state=='US_CA'}SELECTED{/if}>California</option>
    <option value="US_CO" {if $sel_state=='US_CO'}SELECTED{/if}>Colorado</option>
    <option value="US_CT" {if $sel_state=='US_CT'}SELECTED{/if}>Connecticut</option>
    <option value="US_DE" {if $sel_state=='US_DE'}SELECTED{/if}>Delaware</option>
    <option value="US_DC" {if $sel_state=='US_DC'}SELECTED{/if}>District Of Columbia</option>
    <option value="US_FL" {if $sel_state=='US_FL'}SELECTED{/if}>Florida</option>
    <option value="US_GA" {if $sel_state=='US_GA'}SELECTED{/if}>Georgia</option>
    <option value="US_HI" {if $sel_state=='US_HI'}SELECTED{/if}>Hawaii</option>
    <option value="US_ID" {if $sel_state=='US_ID'}SELECTED{/if}>Idaho</option>
    <option value="US_IL" {if $sel_state=='US_IL'}SELECTED{/if}>Illinois</option>
    <option value="US_IN" {if $sel_state=='US_IN'}SELECTED{/if}>Indiana</option>
    <option value="US_IA" {if $sel_state=='US_IA'}SELECTED{/if}>Iowa</option>
    <option value="US_KS" {if $sel_state=='US_KS'}SELECTED{/if}>Kansas</option>
    <option value="US_KY" {if $sel_state=='US_KY'}SELECTED{/if}>Kentucky</option>
    <option value="US_LA" {if $sel_state=='US_LA'}SELECTED{/if}>Louisiana</option>
    <option value="US_ME" {if $sel_state=='US_NE'}SELECTED{/if}>Maine</option>
    <option value="US_MD" {if $sel_state=='US_MD'}SELECTED{/if}>Maryland</option>
    <option value="US_MA" {if $sel_state=='US_MA'}SELECTED{/if}>Massachusetts</option>
    <option value="US_MI" {if $sel_state=='US_MI'}SELECTED{/if}>Michigan</option>
    <option value="US_MN" {if $sel_state=='US_MN'}SELECTED{/if}>Minnesota</option>
    <option value="US_MS" {if $sel_state=='US_MS'}SELECTED{/if}>Mississippi</option>
    <option value="US_MO" {if $sel_state=='US_MO'}SELECTED{/if}>Missouri</option>
    <option value="US_MT" {if $sel_state=='US_MT'}SELECTED{/if}>Montana</option>
    <option value="US_NE" {if $sel_state=='US_NE'}SELECTED{/if}>Nebraska</option>
    <option value="US_NV" {if $sel_state=='US_NV'}SELECTED{/if}>Nevada</option>
    <option value="US_NH" {if $sel_state=='US_NH'}SELECTED{/if}>New Hampshire</option>
    <option value="US_NJ" {if $sel_state=='US_NJ'}SELECTED{/if}>New Jersey</option>
    <option value="US_NM" {if $sel_state=='US_NM'}SELECTED{/if}>New Mexico</option>
    <option value="US_NY" {if $sel_state=='US_NY'}SELECTED{/if}>New York</option>
    <option value="US_NC" {if $sel_state=='US_NC'}SELECTED{/if}>North Carolina</option>
    <option value="US_ND" {if $sel_state=='US_ND'}SELECTED{/if}>North Dakota</option>
    <option value="US_OH" {if $sel_state=='US_OH'}SELECTED{/if}>Ohio</option>
    <option value="US_OK" {if $sel_state=='US_OK'}SELECTED{/if}>Oklahoma</option>
    <option value="US_OR" {if $sel_state=='US_OR'}SELECTED{/if}>Oregon</option>
    <option value="US_PA" {if $sel_state=='US_PA'}SELECTED{/if}>Pennsylvania</option>
    <option value="US_RI" {if $sel_state=='US_RI'}SELECTED{/if}>Rhode Island</option>
    <option value="US_SC" {if $sel_state=='US_SC'}SELECTED{/if}>South Carolina</option>
    <option value="US_SD" {if $sel_state=='US_SD'}SELECTED{/if}>South Dakota</option>
    <option value="US_TN" {if $sel_state=='US_TN'}SELECTED{/if}>Tennessee</option>
    <option value="US_TX" {if $sel_state=='US_TX'}SELECTED{/if}>Texas</option>
    <option value="US_UT" {if $sel_state=='US_UT'}SELECTED{/if}>Utah</option>
    <option value="US_VT" {if $sel_state=='US_VT'}SELECTED{/if}>Vermont</option>
    <option value="US_VA" {if $sel_state=='US_VA'}SELECTED{/if}>Virginia</option>
    <option value="US_WA" {if $sel_state=='US_WA'}SELECTED{/if}>Washington</option>
    <option value="US_WV" {if $sel_state=='US_WV'}SELECTED{/if}>West Virginia</option>
    <option value="US_WI" {if $sel_state=='US_WI'}SELECTED{/if}>Wisconsin</option>
    <option value="US_WY" {if $sel_state=='US_WY'}SELECTED{/if}>Wyoming</option>
	<optgroup label="Canada">
	<option value="CA_AB" {if $sel_state=='CA_AB'}SELECTED{/if}>Alberta</option>
	<option value="CA_BC" {if $sel_state=='CA_BC'}SELECTED{/if}>British Columbia</option>
	<option value="CA_MB" {if $sel_state=='CA_MB'}SELECTED{/if}>Manitoba</option>
	<option value="CA_NB" {if $sel_state=='CA_NB'}SELECTED{/if}>New Brunswick</option>
	<option value="CA_NL" {if $sel_state=='CA_NL'}SELECTED{/if}>Newfoundland</option>
	<option value="CA_NS" {if $sel_state=='CA_NS'}SELECTED{/if}>Nova Scotia</option>
	<option value="CA_NT" {if $sel_state=='CA_NT'}SELECTED{/if}>Northwest Territories</option>
	<option value="CA_NU" {if $sel_state=='CA_NU'}SELECTED{/if}>Nunavut</option>
	<option value="CA_ON" {if $sel_state=='CA_ON'}SELECTED{/if}>Ontario</option>
	<option value="CA_PE" {if $sel_state=='CA_PE'}SELECTED{/if}>Prince Edward Island</option>
	<option value="CA_QC" {if $sel_state=='CA_QC'}SELECTED{/if}>Quebec</option>
	<option value="CA_SK" {if $sel_state=='CA_SK'}SELECTED{/if}>Saskatchewan</option>
	<option value="CA_YT" {if $sel_state=='CA_YT'}SELECTED{/if}>Yukon</option>
	<optgroup label="Mexico">
	<option value="MX_AG" {if $sel_state=='MX_AG'}SELECTED{/if}>Aguascalientes</option>
	<option value="MX_BC" {if $sel_state=='MX_BC'}SELECTED{/if}>Baja California Norte</option>
	<option value="MX_BS" {if $sel_state=='MX_BS'}SELECTED{/if}>Baja California Sur</option>
	<option value="MX_CM" {if $sel_state=='MX_CM'}SELECTED{/if}>Campeche</option>
	<option value="MX_CS" {if $sel_state=='MX_CS'}SELECTED{/if}>Chiapas</option>
	<option value="MX_CH" {if $sel_state=='MX_CH'}SELECTED{/if}>Chihuahua</option>
	<option value="MX_CO" {if $sel_state=='MX_CO'}SELECTED{/if}>Coahuila</option>
	<option value="MX_CL" {if $sel_state=='MX_CL'}SELECTED{/if}>Colima</option>
	<option value="MX_DF" {if $sel_state=='MX_DF'}SELECTED{/if}>Distrito Federal</option>
	<option value="MX_DG" {if $sel_state=='MX_DG'}SELECTED{/if}>Durango</option>
	<option value="MX_GT" {if $sel_state=='MX_GT'}SELECTED{/if}>Guanajuato</option>
	<option value="MX_GR" {if $sel_state=='MX_GR'}SELECTED{/if}>Guerrero</option>
	<option value="MX_HG" {if $sel_state=='MX_HG'}SELECTED{/if}>Hidalgo</option>
	<option value="MX_JA" {if $sel_state=='MX_JA'}SELECTED{/if}>Jalisco</option>
	<option value="MX_MX" {if $sel_state=='MX_MX'}SELECTED{/if}>Mexico</option>
	<option value="MX_MI" {if $sel_state=='MX_MI'}SELECTED{/if}>Michoacán</option>
	<option value="MX_MO" {if $sel_state=='MX_MO'}SELECTED{/if}>Morelos</option>
	<option value="MX_NA" {if $sel_state=='MX_NA'}SELECTED{/if}>Nayarit</option>
	<option value="MX_NL" {if $sel_state=='MX_NL'}SELECTED{/if}>Nuevo Leon</option>
	<option value="MX_OA" {if $sel_state=='MX_OA'}SELECTED{/if}>Oaxaca</option>
	<option value="MX_PU" {if $sel_state=='MX_PU'}SELECTED{/if}>Puebla</option>
	<option value="MX_QT" {if $sel_state=='MX_QT'}SELECTED{/if}>Queretaro</option>
	<option value="MX_QR" {if $sel_state=='MX_QR'}SELECTED{/if}>Quintana Roo</option>
	<option value="MX_SL" {if $sel_state=='MX_SL'}SELECTED{/if}>San Luis Potosi</option>
	<option value="MX_SI" {if $sel_state=='MX_SI'}SELECTED{/if}>Sinaloa</option>
	<option value="MX_SO" {if $sel_state=='MX_SO'}SELECTED{/if}>Sonora</option>
	<option value="MX_TB" {if $sel_state=='MX_TB'}SELECTED{/if}>Tabasco</option>
	<option value="MX_TM" {if $sel_state=='MX_TM'}SELECTED{/if}>Tamaulipas</option>
	<option value="MX_TL" {if $sel_state=='MX_TL'}SELECTED{/if}>Tlaxcala</option>
	<option value="MX_VE" {if $sel_state=='MX_VE'}SELECTED{/if}>Veracruz</option>
	<option value="MX_YU" {if $sel_state=='MX_YU'}SELECTED{/if}>Yucatan</option>
	<option value="MX_ZA" {if $sel_state=='MX_ZA'}SELECTED{/if}>Zacatecas</option>
</select>