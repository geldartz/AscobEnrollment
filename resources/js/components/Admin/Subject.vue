
<template>
    <div class="main-panel">
        <div class="panel-header">
            <div class="header text-center">
            <h2 class="title">Subject Maintenance</h2>
            <p class="p-blur text-center">This page will handle all subject data</p>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a  @click.prevent="openModal"  class="btn btn-primary bg-blue btn-round text-white pull-right btn-for-modal" href="#"><i class="now-ui-icons ui-1_simple-add"></i></a>
                            <h4 class="card-title text-md">Subjects</h4>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-header pt-0 text-right">
                                    <div class="card-tools">
                                        <form action="" class="pull-left py-2 filter-form">
                                            <select class="form-control" name="" id="">
                                                <option value="" disabled selected>Select School Year</option>
                                                <option v-for="data in get_school_years" :key="data.id" :value="data.id">{{ data.school_year }}</option> 
                                            </select>
                                            <select class="form-control" name="" id="">
                                                <option value="" disabled selected>Select Semester</option>
                                                <option v-for="data in get_semesters" :key="data.id" :label="data.semester" :value="data.id"></option> 
                                            </select>
                                            <select v-model="form.course_id" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('course_id') }">
                                                <option label="Select Course" disabled value="" >Select Course</option>
                                                <option v-for="data in get_courses" :key="data.id" :label="data.abbr" @click.prevent="getYearLevels(data)" :value="data.id"></option> 
                                            </select>
                                            <select v-model="form.year_level" class="form-control"  name="" id="" :class="{ 'is-invalid': form.errors.has('year_level') }">
                                                <option label="Select Year Level" disabled value="">Select Year Level</option>
                                                <option v-for="data in get_yearlevels" :key="data" :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
                                            </select>
                                            <button type="button" class="btn btn-tool btn-min">
                                                Filter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table table-hover table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-sm">Course ID</th>
                                                <th class="text-sm">Description</th>
                                                <th class="text-sm">Units</th>
                                                <th class="text-sm">Type</th>
                                                <th class="text-sm">Course & Year</th>
                                                <th class="text-sm w-50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-show="!isLoading">
                                                <td colspan="6" class="text-center"><div class="lds-facebook"><div></div><div></div><div></div></div></td>
                                            </tr>
                                           <tr v-for="data in subjects.data" :key="data.id">
                                               <td>{{ data.short_name }}</td>
                                               <td>{{ data.name }}</td>
                                               <td>{{ data.units }}</td>
                                               <td>{{ data.class }}</td>
                                               <td>{{ data.course.abbr }} - {{ (data.year_level == 1 ? 'I' : data.year_level == 2 ? 'II' :  data.year_level == 3 ? 'III' : data.year_level == 4 ? 'IV' : 'V' ) }}</td>
                                               <td class="text-center"> 
                                                    <a class="pointer" @click="editSubject(data)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>
                                                </td>
                                               
                                           </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <pagination class="float-right" :data="subjects" @pagination-change-page="pageSubject"></pagination>
                        </div>
                    </div>
                </div>




            </div>
        </div>
        <!-- MODALS -->

            <!-- #School Year Modal -->
            <div class="modal fade" id="modal" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl card-info">
                <div class="modal-content">
                        <form  @submit.prevent="editmode ? updateSubject() : createSubject()">
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
                                            <option v-for="data in get_yearlevels" :key="data" :label="(data == 1 ? 'First Year' : data == 2 ? 'Second Year' :  data == 3 ? 'Third Year' : data == 4 ? 'Fourth Year' : 'Fifth YEar' )" :value="data"></option> 
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
                                                <th class="text-sm">Course ID</th>
                                                <th class="w-1-4 text-sm">Description</th>
                                                <th class="text-sm w-100 text-center">Units</th>
                                                <th class="text-sm text-center w-100">Type</th>
                                                <th class="plus-action text-center w-50 p-0"><button @click="addRow($event),counter += 1" class="btn btn-sm bg-blue btn-plus"><i class=" fa fa-plus-circle"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  v-for="(itemData,index) in form.subject" :key="index">
                                                <td>
                                                    <input v-model="itemData.short_name" type="text" name="short_name"
                                                        placeholder="Enter course id"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.short_name') }">
                                                   
                                                </td>
                                                <td>
                                                    <input v-model="itemData.name" type="text" name="name"
                                                        placeholder="Enter subject description"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.name') }">
                                                   
                                                </td>
                                                <td>
                                                    <input v-model="itemData.units" type="text" name="units" v-on:keypress="isNumber()"
                                                        placeholder="0"
                                                        class="form-control" :class="{ 'is-invalid': form.errors.has('subject.units') }">
                                           
                                                </td>
                                                <td>
                                                    <select class="form-control" v-model="itemData.class" name="" id="" :class="{ 'is-invalid': form.errors.has('subject.class') }">
                                                        <option value="Major">Major</option>
                                                        <option value="Minor">Minor</option>
                                                    </select>
                                                  
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
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
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
                            <div class="row">
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
                                        <label>Units</label>
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
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
              get_school_years:[],
              get_semesters:[],
              get_courses:[],
              get_yearlevels:0,
              subjects:{},
              courses:{},
              counter:1,
              form: new Form({
                id: '',
                school_year_id: '',
                semester_id:'',
                course_id:'',
                year_level:'',
                subject:[
                    {
                    id:'',
                    short_name:'',
                    name:'',
                    units:'',
                    class:'',
                    }
                ],
              }),
            }
          },
          methods:{
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
            editSubject(data){
                this.editmode = true;
                this.form.reset();
                this.form.subject[0].id = data.id
                this.form.id = data.id
                this.form.subject[0].short_name = data.short_name
                this.form.subject[0].name = data.name
                this.form.subject[0].units = data.units
                this.form.subject[0].class = data.class

                this.form.school_year_id = data.school_year_id
                this.form.semester_id = data.semester_id
                this.form.course_id = data.course_id
                this.form.year_level = data.year_level
                
                $('#updateModal').modal('show');
            },
            getYearLevels(data){
                axios.get("api/getyearlevels/"+data.id).then(({ data }) => (this.get_yearlevels = data));
            },
            addRow(event){
                 event.preventDefault()
                    this.form.subject.push({
                        index:0,
                        short_name:'',
                        name:'',
                        units:'',
                        class:'',
                  });
                    
            },
            removeRow(itemData,event){
                this.counter--
                event.preventDefault()
                this.form.subject.splice(this.form.subject.indexOf(itemData),1);
            },
            createSubject(){
                this.$Progress.start();
                this.form.post('api/subject')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#modal').modal('hide')
                    this.form.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'All Data Added'
                        })
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
           updateSubject(){
                this.$Progress.start();
                this.form.put('api/subject/'+this.form.id)
                .then((response) => {
                   $('#updateModal').modal('hide');
                     Toast.fire({
                        icon: 'success',
                        title: 'Subject Updated!'
                        })
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                         this.form.reset();
                         this.editmode = false;
                })
                .catch((response) => {
                     this.$Progress.fail();
                });
            },
            pageSubject(){
                axios.get('api/subject?page=' + page)
                    .then(response => {
                        this.subjects = response.data.data;
                    });
            },
        
            loadSettings(){
                axios.get('api/subject')
                    .then((data) => {
                    this.isLoading = false
                    this.subjects = data.data.data
                    
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

            this.loadSettings();
            Fire.$on('AfterCreate',() => {
               axios.get('api/subject')
                    .then((data) => {
                    this.isLoading = false
                    this.subjects = data.data.data
                    
                    })
                    .finally(() => {
                        this.isLoading = true
                    });
            });

        }
    }
</script>
