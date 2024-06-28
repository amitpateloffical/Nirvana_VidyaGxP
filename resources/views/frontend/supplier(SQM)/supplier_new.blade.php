@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }
</style>

<div class="form-field-head">
   
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        QMS-North America / Supplier
    </div>
   
</div>






    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Supplier/Manufacturer/Vender</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> Supplier Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')"> Score Card</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')"> Risk Assessment</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
            </div>

            <!--  Contract Tab content -->
            <div id="CCForm1" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"><b>Initiator</b></label>
                                <input disabled type="text" name="Initiator" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiation"><b>Date Opened</b></label>
                                <input disabled type="date" name="Date_of_Initiation" value="">
                                <input type="hidden" name="date_opened" value="">
                            </div>
                        </div>

                        

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Assigned To <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="assign_to">
                                    <option value="">Select a value</option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="due-date">Date Due</label>
                                <div><small class="text-primary">Please mention expected date of completion</small></div>
                                <div class="calenderauditee">
                                    <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                characters remaining
                                <input id="docname" type="text" name="short_description" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Supplier.">Supplier</label>
                                <select name="assigend">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for=" Attachments">Logo</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="logo_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="logo_Attachment" name="logo_Attachment[]"
                                            oninput="addMultipleFiles(this, 'logo_Attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Contact Person">Contact Person</label>
                                <select name="supplier_contact_person">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Suppliers Products">Suppliers Products</label>
                                <select multiple name="supplier_products" placeholder="Select Suppliers Products"
                                    data-search="false" data-silent-initial-value-set="true" id="supplier-product">
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Description">Description</label>
                                <textarea name="description"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Type..">Type</label>
                                <select name="supplier_type">
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Sub Type.">Sub Type</label>
                                <select name="supplier_sub_type">
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Other Type">Other Type</label>
                                <input type="text" name="supplier_other_type">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supply from">Supply from</label>
                                <input type="text" name="supply_from">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supply to">Supply to</label>
                                <input type="text" name="supply_to">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier Web Site">Supplier Web Site</label>
                                <input type="url" name="supplier_website">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Web Search">Web Search</label>
                                <input type="search" name="supplier_web_search">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Audit Attachments">Attached Files</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="supplier_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="supplier_attachment" name="supplier_attachment[]"
                                            oninput="addMultipleFiles(this, 'supplier_attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Related URLs">Related URLs</label>
                                <input type="url" name="related_url">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Related Quality Events">Related Quality Events</label>
                                <input type="text" name="related_quality_events">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Of Complaints/Deviations"># Of Complaints/Deviations</label>
                                <input type="text" name="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="total demerit points">Total Demerit Points</label>
                                <input type="text" name="">
                            </div>
                        </div>
                    </div>

                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                    </div>
                </div>
            </div>
            <!-- Supplier Details content -->
            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Issues">
                                    Certifications & Accreditation<button type="button" name="ann" onclick="add6Input('issues')">+</button>
                                </label>
                                <table class="table table-bordered" id="issues">
                                    <thead>
                                        <tr>
                                            <th>Row #</th>
                                            <th>Type</th>
                                            <th>Issuing Agancy</th>
                                            <th>Issue Date</th>
                                            <th>Expiry Date</th>
                                            <th>Supporting Document</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier.">Supplier</label>
                                <select name="supplier_name">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier.">Supplier ID</label>
                               <input type="text" name="supplier_id">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="">Manufacturer</label>
                                <select name="manufacturer_name">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="manufacturer">Manufacturer ID</label>
                               <input type="text" name="manufacturer_id">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="">Vender</label>
                                <select name="vender_name">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="manufacturer">Vender ID</label>
                               <input type="text" name="vender_id">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Contact Person">Contact Person</label>
                                <select name="assigend">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Other Contacts">Other Contacts</label>
                                <select multiple name="other_contacts" placeholder="Select Suppliers Products"
                                    data-search="false" data-silent-initial-value-set="true" id="other-products">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Supplier Services">Supplier Services</label>
                                <textarea name="supplier_service" id="" cols="30" ></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Zone">Zone</label>
                                <select name="zone">
                                    <option>Enter Your Selection Here</option>
                                    <option>Asia</option>
                                    <option>Europe</option>
                                    <option>Africa</option>
                                    <option>Central America</option>
                                    <option>South America</option>
                                    <option>Oceania</option>
                                    <option>North America</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Country">Country</label>
                                <select name="country">
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="City">City</label>
                                <select name="city">
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Address">Address</label>
                                <input type="text" name="String">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier Web Site">Supplier Web Site</label>
                                <input type="url" name="url" id="url">
                            </div>
                        </div>
                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="ISO Certification date">ISO Certification Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="iso_certification_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="iso_certification_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'iso_certification_date')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Contracts">Contracts</label>
                                <input type="text" name="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Related Non Conformances">Related Non Conformances</label>
                                <input type="text" name="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier Contracts/Agreements">Supplier Contracts/Agreements</label>
                                <input type="file" id="myfile" name="supplier_contracts">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Regulatory History">Regulatory History</label>
                                <input type="file" id="myfile" name="regulatory_history">
                            </div>
                        </div>
                       
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Distribution Sites">Distribution Sites</label>
                                <select name="distribution_sites">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="text">text</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Manufacturing Sites">Manufacturing Sites</label>
                                <select multiple name="manufacture_sites" placeholder="Select Manufacturing Sites"
                                    data-search="false" data-silent-initial-value-set="true" id="manufacture-sites">
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                    <option value="text">text</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Quality Management ">Quality Management </label>
                                <textarea name="text"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Business History">Business History</label>
                                <textarea name="text"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Performance History ">Performance History </label>
                                <textarea name="text"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Compliance Risk">Compliance Risk</label>
                                <textarea name="text"></textarea>
                            </div>
                        </div>
                        
                      
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                    </div>
                </div>
            </div>
            <!-- score card content -->
            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Cost Reduction">Cost Reduction</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Cost Reduction Weight">Cost Reduction Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Payment Terms">Payment Terms</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="CPayment Terms Weight">Payment Terms Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Lead Time Days">Lead Time Days</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Lead Time Days Weight">Lead Time Days Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="On-Time Delivery">On-Time Delivery</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="On-Time Delivery Weight">On-Time Delivery Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier Business Planning">Supplier Business Planning</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Supplier Business Weight">Supplier Business Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Rejection in PPM">Rejection in PPM</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Rejection in PPM Weight">Rejection in PPM Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Systems">Quality Systems</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Systems Weight">Quality Systems Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="# of CAR's generated"># of CAR's generated</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="# of CAR's generated Weight"># of CAR's generated Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="CAR Closure Time">CAR Closure Time</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="CAR Closure Time Weight">CAR Closure Time Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="End-User Satisfaction">End-User Satisfaction</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="End-User Satisfaction Weight">End-User Satisfaction Weight</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 sub-head">
                            Total Score
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Scorecard Record">Scorecard Record</label>
                                <input type="text" name="scorecard_recod">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Achived Score">Achived Score</label>
                                <input type="text" name="achived_score">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Available Score">Total Available Score</label>
                                <input type="text" name="total_available_score">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Score">Total Score</label>
                                <input type="text" name="total_score">
                            </div>
                        </div>
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                    </div>
                </div>
            </div>
            <!-- General information content -->
            <div id="CCForm4" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Last Audit Date">Last Audit Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="last_audit_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="last_audit_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'last_audit_date')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Last Audit Date">Next Audit Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="next_audit_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="next_audit_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'next_audit_date')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Audit Frequency">Audit Frequency</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Last Audit Result">Last Audit Result</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 sub-head">
                            Risk Factors
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Facility Type">Facility Type</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Number of Employees">Number of Employees</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Access to Technical Support">Access to Technical Support</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Services Supported">Services Supported</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Reliability">Reliability</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Revenue">Revenue</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Client Base">Client Base</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Previous Audit Results">Previous Audit Results</label>
                                <select>
                                    <option>Enter Your Selection Here</option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="sub-head">
                            Results
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Available Score">Risk Row Total</label>
                                <input type="text" name="risk_row_total">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Available Score">Risk Median</label>
                                <input type="text" name="risk_median">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Available Score">Risk Average</label>
                                <input type="text" name="risk_average">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Total Available Score">Risk Assessment Total</label>
                                <input type="text" name="risk_assessment_total">
                            </div>
                        </div>
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                    </div>
                </div>
            </div>
          
            <!-- Signature content -->
            <div id="CCForm5" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Qualify By">Qualify By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Qualify On">Qualify On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        VirtualSelect.init({
            ele: '#supplier-product, #ppap-elements, #supplier-services, #other-products, #manufacture-sites'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endsection
