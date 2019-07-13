    List = function($data = []){
        this.$data = [];
        this.$edit_list = [];
        this.$hospitals_lists = $data;

        this.add_component = function ($hospital = {}) {
            this.$data.unshift($hospital);
        }


        this.add_to_edit_list = function ($hospital = {}) {
            this.$edit_list.unshift($hospital);
            $('#edit_data').modal('show');
        }



        this.delete_component = function($hospital) {

            for(x in this.$data){
                
                if ($hospital == this.$data[x]) {
                    this.$data.splice(x, 1);
                }
            }
        }


        this.delete_edit_list = function($hospital) {

            for(x in this.$edit_list){
                
                if ($hospital == this.$edit_list[x]) {
                    this.$edit_list.splice(x, 1);
                }
            }
        }

        this.edit_hospital = function($hospital){
            this.add_to_edit_list($hospital);
        }   


        this.remove_hospital_from_table = function($hospital) {

            for(x in this.$hospitals_lists){
                
                if ($hospital == this.$hospitals_lists[x]) {
                    this.$hospitals_lists.splice(x, 1);
                }
            }
        }


        this.attempt_delete = function($hospital){
                window.$confirm_dialog = new DialogJS(this.delete, [$hospital, this] );
        }


        this.delete =  function($hospital, $this){
            $hospital_id = $hospital.id;

                            console.log($hospital);

                $("#page_preloader").css('display', 'block');
                   $.ajax({
                        type: "POST",
                        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                        processData: false, // NEEDED, DON'T OMIT THIS
                        url: $base_url+"/hris_settings/delete_hospital/"+$hospital_id,
                        cache: false,
                        success: function(data) {

                            console.log($this);
                            console.log(data);
                         
                                window.notify();
                                if (data.response == true) {
                                    $this.remove_hospital_from_table($hospital);
                                 angular.element($('#hospital_lists')).scope().$apply();                         
                                }
                              
                        },
                        error: function (data) {
                        },
                        complete: function(){
                         
                            $("#page_preloader").css('display', 'none');

                        }
                    });
        }


}

    


    app.controller('CompanyController', function($scope, $http) {

            $scope.$data = [];
            $scope.fetch_page_content = function ($month=null) {
                console.log($month);

                        $("#page_preloader").css('display', 'block');

                        $http.get($base_url+'/hris_settings/fetch_hospitals_list')
                            .then(function(response) {
                                $data = response.data;

                                    console.log($data);
                                    
                                    $scope.$data = $data; 

                                    $scope.$list = new List($data.hospitals_list);  

                                    // console.log($scope.$hospitals_list);

                                    $("#page_preloader").css('display', 'none');
                        });

                }

            $scope.fetch_page_content();



    });           


