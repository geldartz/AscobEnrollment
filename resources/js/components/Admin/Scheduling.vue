
<template>
    <div class="main-panel">
        <div class="panel-header">
            <div class="header text-center">
            <h2 class="title">Subject Scheduling</h2>
            <p class="p-blur text-center">This page will handle all subject schedules</p>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openModal" class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons ui-1_simple-add"></i></a>
                            <h4 class="card-title text-md">Subject Schedules</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-min" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">Course #</th>
                                                <th class="text-sm">Description</th>
                                                <th class="text-sm">Unit(s)</th>
                                                <th class="text-sm">Day(s)</th>
                                                <th class="text-sm">Room</th>
                                                <th class="text-sm">Time</th>
                                                <th class="text-sm w-50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="!isLoading">
                                                <td colspan="7" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td>
                                            </tr>
                                            <tr v-for="data in schedules.data" :key="data.id">
                                                <td> {{ data.subject.short_name }} </td>
                                                <td> {{ data.subject.name }} </td>
                                                <td> {{ data.subject.units }} </td>
                                                <td> {{ data.days }} </td>
                                                <td> {{ data.room }} </td>
                                                <td> {{ data.time }} </td>
                                                <td class="text-center"> 
                                                    <a class="pointer" @click="editSchedule(data)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


    

            </div>
        </div>
        <!-- MODALS -->

             <div class="modal fade" id="modal" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl card-info">
                <div class="modal-content">
                        <form  @submit.prevent="createSchedule()">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>School Year</label>
                                            <select v-model="form.school_year_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('school_year_id') }">
                                                <option label="Select School Year" disabled value="">Select School Year</option>
                                                <option v-for="data in get_school_years" :key="data.id" :value="data.id">{{ data.school_year }}</option> 
                                            </select>
                                        <has-error :form="form" field="school_year_id"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select v-model="form.semester_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('semester_id') }">
                                            <option label="Select Semester" disabled value="">Select Semester</option>
                                            <option v-for="data in get_semesters" :key="data.id" :label="data.semester" :value="data.id"></option> 
                                        </select>
                                        <has-error :form="form" field="semester_id"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>Course</label>
                                        <select v-model="form.course_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('course_id') }">
                                            <option label="Select Course" disabled value="" >Select Course</option>
                                            <option v-for="data in get_courses" :key="data.id" :label="data.abbr" @click.prevent="getYearLevels(data)" :value="data.id"></option> 
                                        </select>
                                        <has-error :form="form" field="course_id"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Year Level</label>
                                        <select v-model="form.year_level" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('year_level') }">
                                            <option label="Select Year Level" disabled value="">Select Year Level</option>
                                            <option v-for="data in get_yearlevels" :key="data" @click.prevent="getSubjects(data)"
                                            :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
                                        </select>
                                        <has-error :form="form" field="year_level"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-stripped table-bordered populate">
                                        <thead>
                                            <tr>
                                                <th class="w-1-4 text-sm">Subject Description</th>
                                                <th class="text-sm w-100 text-center">Units</th>
                                                <th class="text-sm text-center w-100">Days</th>
                                                <th class="text-sm text-center w-150">Room</th>
                                                <th class="text-sm text-center w-150">Time</th>
                                                <th class="plus-action text-center w-50 p-0"><button :disabled="isVal == false" @click="addRow($event),counter += 1" class="btn btn-sm bg-blue btn-plus"><i class=" fa fa-plus-circle"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr  v-for="(itemData,index) in form.subject" :key="index">
                                                <td>
                                                    <select v-model="itemData.name" name="" id="selectme" class="form-control test" >
                                                        <option disabled label="Select Description" value="">Select Description</option>
                                                        <option v-for="data in subjects" :key="data.id" :value="data.id" @click.prevent="getUnits(data,index)">{{data.name}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input v-model="itemData.units" type="text" name="units" v-on:keypress="isNumber()"
                                                        placeholder="0" disabled
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.units') }">
                                                </td>
                                                <td>
                                                    <input v-model="itemData.days" type="text" name="units"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.days') }">
                                                </td>
                                                <td>
                                                    <input v-model="itemData.room" type="text" name="room"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.room') }">
                                                </td>
                                                <td>
                                                    <input v-model="itemData.time" type="text" name="time"
                                                        placeholder="00:00AM - 00:00PM"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.time') }">
                                                </td>
    
                                                <td class="text-center">
                                                    <button  @click="removeRow(itemData,$event)" class="btn btn-sm btn-minus"><i class="fa fa-minus-circle"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                            <button :disabled="isVal == false" v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>

             <div class="modal fade" id="updateModal" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl card-info">
                <div class="modal-content">
                        <form  @submit.prevent="updateSubject()">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h2 class="text-center">Under Developement</h2>
                            <!-- <div class="row">
                                <input v-model="form.subject[0].id" type="hidden">
                                <input v-model="form.school_year_idd" type="hidden">
                                <input v-model="form.semester_id" type="hidden">
                                <input v-model="form.course_id" type="hidden">
                                <input v-model="form.year_level" type="hidden">
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>School Year</label>
                                            <input v-model="form.subject[0].short_name" type="text" name="short_name"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('short_name') }">
                                        <has-error :form="form" field="short_name"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <input v-model="form.subject[0].name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-custom">
                                    <div class="form-group">
                                        <label>Course</label>
                                        <input v-model="form.subject[0].units" type="text" name="units" class="form-control" :class="{ 'is-invalid': form.errors.has('units') }">
                                        <has-error :form="form" field="units"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Year Level</label>
                                        <select class="form-control" v-model="form.subject[0].class" name="" id="" :class="{ 'is-invalid': form.errors.has('class') }">
                                            <option :selected="form.subject.class == 'Major' ? true : false"  value="Major">Major</option>
                                            <option :selected="form.subject.class == 'Minor' ? true : false" value="Minor">Minor</option>
                                        </select>
                                        <has-error :form="form" field="year_level"></has-error>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button disabled type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>


   </div>
</template>

<script>
    export default {
        data () {
            return {
              editmode: false,
              isLoading: false,
              isVal:false,
              get_school_years:[],
              get_semesters:[],
              get_courses:[],
              get_units:[],
              get_yearlevels:0,
              subjects:{},
              courses:{},
              schedules:{},
              counter:1,
              form: new Form({
                id: '',
                school_year_id: '',
                semester_id:'',
                course_id:'',
                year_level:'',
                subject:[
                    {
                    name:'',
                    units:'',
                    days:'',
                    room:'',
                    time:'',
                    }
                ],
              }),

            }
          },
          methods:{
          // COURSE METHODS

            openModal(){
                    this.editmode = false;
                    this.form.reset();
                    $('#modal').modal('show');
                },
            isNumber: function(evt) {
              evt = (evt) ? evt : window.event;
              var charCode = (evt.which) ? evt.which : evt.keyCode;
              if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
                 Toast.fire({
                        icon:'warning',
                        type: 'warning',
                        title: 'Number Only.'
                        })
               
              } else {
                return true;
              }
            },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },
            addRow(event){
               
                 event.preventDefault()
                    this.form.subject.push({
                        index:0,
                        name:'',
                        units:'',
                        days:'',
                        room:'',
                        time:'',
                  });
                    
            },
            removeRow(itemData,event){
                this.counter--
                event.preventDefault()
                this.form.subject.splice(this.form.subject.indexOf(itemData),1);
            },
            getUnits(data,index){
                
               if(this.form.subject[index].name == data.id){
                //    this.form.subject[index].name.remove
                   $("#selectme option[value='"+data.id+"']").eq(index+1).remove();
               }
        
            

                axios.get("api/subject/"+data.id)
                .then((data) => {
                   this.form.subject[index].units = data.data[0].units
                })
                .finally(() => {
                    this.isLoading = true
                }); 
                
                
            },
            getSubjects(data){
                var sy_id = this.form.school_year_id
                var sem_id = this.form.semester_id
                var cour_id = this.form.course_id
                var yl = data
                if(sy_id == "" || sem_id == "" || cour_id == "" || yl == ""){
                    Toast.fire({
                            icon: 'warning',
                           title: 'All select fields are required'
                        })
                }else{
                    this.isVal = true
                    axios.get("api/getsubject/"+sy_id+"/"+sem_id+"/"+cour_id+"/"+yl).then(({ data }) => (this.subjects = data));
                }

            },
            createSchedule(){
                this.$Progress.start();
                this.form.post('api/schedule')
                .then((response)=>{
                    Fire.$emit('AfterCreate');
                     $('#modal').modal('hide')
                 
                        Toast.fire({
                        icon: 'success',
                        title: 'All Data Added'
                        })
                    
                    this.form.reset();
                    
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Toast.fire({
                        icon: 'warning',
                        title: 'Opp! Something went wrong'
                    })
                })
            },
            editSchedule(data){
                    this.editmode = true;
                   $('#updateModal').modal('show');
                },
            // updateCourse(){
            //     this.$Progress.start();
            //     this.courseForm.put('api/course/'+this.courseForm.id)
            //     .then(() => {
            //         $('#modal-course').modal('hide');
            //             Toast.fire({
            //             icon: 'success',
            //             title: 'Course Updated!'
            //             })
            //             this.$Progress.finish();
            //                 Fire.$emit('AfterCreateCourse');
            //                 this.courseForm.reset();
            //                 this.editmode = false;
            //     })
            //     .catch(() => {
            //         this.$Progress.fail();
            //     });
            // },        

            // pageCourse(){
            //     axios.get('api/course?page=' + page)
            //             .then(response => {
            //                 this.courses = response.data.data;
            //             });
            // },
           

         


            loadSettings(){
                axios.get('api/schedule')
                .then((data) => {
                    this.isLoading = false
                    this.schedules = data.data.data
                    
                })
                .finally(() => {
                    this.isLoading = true
                }); 
            },
          },
        async created(){
             axios.get("api/getschoolyear").then(({ data }) => (this.get_school_years = data));
             axios.get("api/getsemester").then(({ data }) => (this.get_semesters = data));
             axios.get("api/getcourse").then(({ data }) => (this.get_courses = data));
            

             this.loadSettings();

             Fire.$on('AfterCreate',() => {
              axios.get('api/schedule')
                .then((data) => {
                    this.isLoading = false
                    this.schedules = data.data.data
                    
                })
                .finally(() => {
                    this.isLoading = true
                }); 
            });

        }
    }
</script>
