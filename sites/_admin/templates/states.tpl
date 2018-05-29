<select {if $ctl}name="{$ctl}" id="{$ctl}-id"{/if} class="form-control" {if $ro|default: ''} READONLY{/if}>
    <option value="" selected="selected">Select...</option>
    <option value="AL" {if $sel_state|default: ''=='AL'}SELECTED{/if}>Alabama</option>
    <option value="AK" {if $sel_state|default: ''=='AK'}SELECTED{/if}>Alaska</option>
    <option value="AZ" {if $sel_state|default: ''=='AZ'}SELECTED{/if}>Arizona</option>
    <option value="AR" {if $sel_state|default: ''=='AR'}SELECTED{/if}>Arkansas</option>
    <option value="CA" {if $sel_state|default: ''=='CA'}SELECTED{/if}>California</option>
    <option value="CO" {if $sel_state|default: ''=='CO'}SELECTED{/if}>Colorado</option>
    <option value="CT" {if $sel_state|default: ''=='CT'}SELECTED{/if}>Connecticut</option>
    <option value="DE" {if $sel_state|default: ''=='DE'}SELECTED{/if}>Delaware</option>
    <option value="DC" {if $sel_state|default: ''=='DC'}SELECTED{/if}>District Of Columbia</option>
    <option value="FL" {if $sel_state|default: ''=='FL'}SELECTED{/if}>Florida</option>
    <option value="GA" {if $sel_state|default: ''=='GA'}SELECTED{/if}>Georgia</option>
    <option value="HI" {if $sel_state|default: ''=='HI'}SELECTED{/if}>Hawaii</option>
    <option value="ID" {if $sel_state|default: ''=='ID'}SELECTED{/if}>Idaho</option>
    <option value="IL" {if $sel_state|default: ''=='IL'}SELECTED{/if}>Illinois</option>
    <option value="IN" {if $sel_state|default: ''=='IN'}SELECTED{/if}>Indiana</option>
    <option value="IA" {if $sel_state|default: ''=='IA'}SELECTED{/if}>Iowa</option>
    <option value="KS" {if $sel_state|default: ''=='KS'}SELECTED{/if}>Kansas</option>
    <option value="KY" {if $sel_state|default: ''=='KY'}SELECTED{/if}>Kentucky</option>
    <option value="LA" {if $sel_state|default: ''=='LA'}SELECTED{/if}>Louisiana</option>
    <option value="ME" {if $sel_state|default: ''=='NE'}SELECTED{/if}>Maine</option>
    <option value="MD" {if $sel_state|default: ''=='MD'}SELECTED{/if}>Maryland</option>
    <option value="MA" {if $sel_state|default: ''=='MA'}SELECTED{/if}>Massachusetts</option>
    <option value="MI" {if $sel_state|default: ''=='MI'}SELECTED{/if}>Michigan</option>
    <option value="MN" {if $sel_state|default: ''=='MN'}SELECTED{/if}>Minnesota</option>
    <option value="MS" {if $sel_state|default: ''=='MS'}SELECTED{/if}>Mississippi</option>
    <option value="MO" {if $sel_state|default: ''=='MO'}SELECTED{/if}>Missouri</option>
    <option value="MT" {if $sel_state|default: ''=='MT'}SELECTED{/if}>Montana</option>
    <option value="NE" {if $sel_state|default: ''=='NE'}SELECTED{/if}>Nebraska</option>
    <option value="NV" {if $sel_state|default: ''=='NV'}SELECTED{/if}>Nevada</option>
    <option value="NH" {if $sel_state|default: ''=='NH'}SELECTED{/if}>New Hampshire</option>
    <option value="NJ" {if $sel_state|default: ''=='NJ'}SELECTED{/if}>New Jersey</option>
    <option value="NM" {if $sel_state|default: ''=='NM'}SELECTED{/if}>New Mexico</option>
    <option value="NY" {if $sel_state|default: ''=='NY'}SELECTED{/if}>New York</option>
    <option value="NC" {if $sel_state|default: ''=='NC'}SELECTED{/if}>North Carolina</option>
    <option value="ND" {if $sel_state|default: ''=='ND'}SELECTED{/if}>North Dakota</option>
    <option value="OH" {if $sel_state|default: ''=='OH'}SELECTED{/if}>Ohio</option>
    <option value="OK" {if $sel_state|default: ''=='OK'}SELECTED{/if}>Oklahoma</option>
    <option value="OR" {if $sel_stat|default: ''=='OR'}SELECTED{/if}>Oregon</option>
    <option value="PA" {if $sel_state|default: ''=='PA'}SELECTED{/if}>Pennsylvania</option>
    <option value="RI" {if $sel_state|default: ''=='RI'}SELECTED{/if}>Rhode Island</option>
    <option value="SC" {if $sel_state|default: ''=='SC'}SELECTED{/if}>South Carolina</option>
    <option value="SD" {if $sel_state|default: ''=='SD'}SELECTED{/if}>South Dakota</option>
    <option value="TN" {if $sel_state|default: ''=='TN'}SELECTED{/if}>Tennessee</option>
    <option value="TX" {if $sel_state|default: ''=='TX'}SELECTED{/if}>Texas</option>
    <option value="UT" {if $sel_state|default: ''=='UT'}SELECTED{/if}>Utah</option>
    <option value="VT" {if $sel_state|default: ''=='VT'}SELECTED{/if}>Vermont</option>
    <option value="VA" {if $sel_state|default: ''=='VA'}SELECTED{/if}>Virginia</option>
    <option value="WA" {if $sel_state|default: ''=='WA'}SELECTED{/if}>Washington</option>
    <option value="WV" {if $sel_state|default: ''=='WV'}SELECTED{/if}>West Virginia</option>
    <option value="WI" {if $sel_state|default: ''=='WI'}SELECTED{/if}>Wisconsin</option>
    <option value="WY" {if $sel_state|default: ''=='WY'}SELECTED{/if}>Wyoming</option>
</select>