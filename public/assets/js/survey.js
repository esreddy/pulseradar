$(document).ready(function(){

    $(document).off("click", ".openGenQuesModal").on("click", ".openGenQuesModal", function(){
        alert('Click');
        $('#generalQuesModal').find("input[type=text], textarea").val("");
        $('#generalQuesModal').find("#hiddenGenBlcNum").val("");
        $('#generalQuesModal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    })







    $(document).off("click", ".btnNext").on("click", ".btnNext", function(){
        $('.nav-tabs').find('a.active').parent().next('li').find('a').trigger("click");
    })

    $(document).off("click", ".btnPrevious").on("click", ".btnPrevious", function(){
        $('.nav-tabs').find('a.active').parent().prev('li').find('a').trigger("click");
    })

    $(document).off("keypress", ".required, .required2").on("keypress", ".required, .required2", function(){
        $(this).closest('div').find('.validate_msg').text("").removeClass('error');
    })

    $(document).off("keypress", "#leadQuesName").on("keypress", "#leadQuesName", function(){
        $(this).closest('div').find('.leaderQues_err').text("").removeClass('error');
    })

    $(document).off("change", "select").on("change", "select", function(){
        $(this).closest('div').find('.validate_msg').text("").removeClass('error');
    })

    $(document).off("change", "#start_date_time, #end_date_time").on("change", "#start_date_time, #end_date_time", function(){
        $(this).closest('div').find('.validate_msg').text("").removeClass('error');
    })

    $('#constituency, #ward').selectpicker();



    $(document).off("change", "#skipleadques").on("change", "#skipleadques", function(){

        if($(this).prop("checked") == true)
        {
            $(".tab5").trigger("click");
        }
    })

    $(document).off("click", ".deleteLeadQues").on("click", ".deleteLeadQues", function(){
        $(this).closest(".singleLeadQues").find(".leaderOptions").html("");
    })

    $(document).off("click", ".openLeadQuesModal").on("click", ".openLeadQuesModal", function(){

        var cid = $(this).closest(".singleLeadQues").attr("key")
        var cname = $(this).closest(".singleLeadQues").attr("name")
        $("#leaderQuesModal").find("h5").text(cname);
        $("#clickedDependId").val(cid);

        var optGCnt = 0;
        console.log($(this).closest(".singleLeadQues").find(".leadQuesLabls").length)
        $(this).closest(".singleLeadQues").find(".leadQuesLabls").each(function(){
            optGCnt++;
            $("#leadQuesOpt"+optGCnt).val($(this).text());
        })

        $('#leaderQuesModal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    })

    $(document).off("change", "#constituency").on("change", "#constituency", function(){
        //if($('input[name="atype"]:checked').val() == 1)

        let leadQueDv = $(this).val().map((x) => {
            //let selectedOpt = $("option[key='atype_"+x+"']").attr("value");
            let selectedTxt = $(this).find("option[key='atype_"+x+"']").text();

            return `<div class="singleLeadQues singleLeadQues_${x}" key="${x}" name="${selectedTxt}">
                        <input type="hidden" name="dependName[]" value="${selectedTxt}">
                        <input type="hidden" name="dependId[]" value="${x}">
                        <label class="form-check-label">${selectedTxt}</label>
                        <button type="button" class="btn btn-info openLeadQuesModal" data-toggle="modal">Add</button>
                        <button type="button" class="btn btn-info deleteLeadQues" data-toggle="modal">Delete</button>
                        <div class="leaderOptions"></div>
                    </div>`;
        })

        $(".constituency_err, .ward_err").text("").removeClass("error");
        $(".leaderQuestionBlock").html(leadQueDv);

    })

    $(document).off("change", "#ward").on("change", "#ward", function(){
        //if($('input[name="atype"]:checked').val() == 1)

        let leadQueDv = $(this).val().map((x) => {
            //let selectedOpt = $("option[key='atype_"+x+"']").attr("value");
            let selectedTxt = $(this).find("option[key='atype_"+x+"']").text();
            if($(".singleLeadQues_"+x).length == 0)
            {

                return `<div class="singleLeadQues singleLeadQues_${x}" key="${x}" name="${selectedTxt}">
                            <input type="hidden" name="dependName[]" value="${selectedTxt}">
                            <input type="hidden" name="dependId[]" value="${x}">
                            <label class="form-check-label">${selectedTxt}</label>
                            <button type="button" class="btn btn-info openLeadQuesModal" data-toggle="modal">Add</button>
                            <button type="button" class="btn btn-info deleteLeadQues" data-toggle="modal">Delete</button>
                            <div class="leaderOptions"></div>
                        </div>`;
            }
        })

        $(".constituency_err, .ward_err").text("").removeClass("error");
        $(".leaderQuestionBlock").append(leadQueDv);

        $(".singleLeadQues").each(function(){
            let wrid = $(this).attr("key");
            let selectedWrds = $("#ward").val();
            if(!selectedWrds.includes(wrid))
            {
                $(".singleLeadQues_"+wrid).remove();
            }
            //console.log($("#ward").find("option[key='"+wrid+"']").attr("selected"))
        })

        var $wrapper = $('.leaderQuestionBlock');
        $wrapper.find('.singleLeadQues').sort(function (a, b) {
            return +a.getAttribute("key") - +b.getAttribute("key");
        })
        .appendTo( $wrapper );

    })

    $(document).off("click", ".addGenQuestion").on("click", ".addGenQuestion", function(){
       if($("#genQuesName").val().trim() == "")
       {
            $(".genQuesName_err").text("Enter question").addClass("error");
       } else
       {
        $(".genQuesName_err").text("").removeClass("error");
            let quesType = $(".genQuesType:checked").val();
            let totalGenQues = $(".genQuesBlock").find(".singleGenQues").length;
            let quesOptions = "";
            $(".genQuesOpt").each(function(){
                if(this.value != "")
                {
                    if(quesType == 1)
                    {
                        quesOptions += `<div class="form-group">
                            <input type="hidden" name="genQuesOptView${totalGenQues}[]" value="${this.value}" >
                            <input class="form-check-input changeStatus" type="radio" value="${this.value}">
                            <label class="form-check-label question_name_options" for="Option1">${this.value}</label>
                        </div>`;
                    } else
                    {
                        quesOptions += `<div class="form-group">
                            <input type="hidden" name="genQuesOptView${totalGenQues}[]" value="${this.value}" >
                            <input class="form-check-input changeStatus" type="checkbox" name="genQuesOptView${totalGenQues}[]" value="${this.value}">
                            <label class="form-check-label" for="Option1">${this.value}</label>
                        </div>`;
                    }
                }
            })

            let quesionBlc = `<div class="singleGenQues singleGenQues_${totalGenQues}" key="${totalGenQues}">
                            <div class="form-check innerGenQues">
                               <label class="col-form-label question_name">${$("#genQuesName").val()}
                               <input type="hidden" name="genQuesNameView[]" value="${$("#genQuesName").val()}" />
                               <input type="hidden" name="genQuesTypeView${totalGenQues}[]" value="${quesType}" />
                               </label><br/>
                                ${quesOptions }
                                <br/>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary delGenQues">Delete</button> &nbsp;
                            </div>
                            <hr/></div>`;

            /*if($("#hiddenGenBlcNum").val() != undefined && $("#hiddenGenBlcNum").val() != "")
            {
                $("#editedGenQuesHidden").html(quesionBlc);
                if($(".singleGenQues_"+$("#hiddenGenBlcNum").val()).length > 0)
                {
                    //$(".singleGenQues_"+$("#hiddenGenBlcNum").val()).remove();
                    $(".singleGenQues_"+$("#hiddenGenBlcNum").val()).html($("#editedGenQuesHidden").find(".singleGenQues").html());
                }
            } else
            {
                $(".genQuesBlock").append(quesionBlc);
            }*/

            $(".genQuesBlock").append(quesionBlc);

            $(".generalQue_err").text("").removeClass("error");
            $("#generalQuesModal").find('input[type="text"], textarea').val("");
            $("#hiddenGenBlcNum").val("");
       }
   })

$(document).off("click", ".editGenQuestion").on("click", ".editGenQuestion", function(){
quesionBlcNoJs=$("#hiddenGenBlcNumEdit").val();
genQuesIdJs=$("#genQuesIdView"+quesionBlcNoJs).val();
alert(genQuesIdJs);

  if($("#genQuesNameEdit").val().trim() == "")
       {
            $(".genQuesName_errEdit").text("Enter question").addClass("error");
       } else
           {
        $(".genQuesName_errEdit").text("").removeClass("error");
            let quesType = $(".genQuesTypeEdit:checked").val();
            //let totalGenQues = $(".genQuesBlock").find(".singleGenQues").length;
            let totalGenQues = quesionBlcNoJs;
            let quesOptions = "";
            $(".genQuesOptEdit").each(function(){
                if(this.value != "")
                {
                    if(quesType == 1)
                    {
                        quesOptions += `<div class="form-group">
                            <input type="hidden" name="genQuesOptView${totalGenQues}[]" value="${this.value}" >
                            <input class="form-check-input changeStatus" type="radio" value="${this.value}">
                            <label class="form-check-label question_name_options" for="Option1">${this.value}</label>
                        </div>`;
                    } else
                    {
                        quesOptions += `<div class="form-group">
                            <input type="hidden" name="genQuesOptView${totalGenQues}[]" value="${this.value}" >
                            <input class="form-check-input changeStatus" type="checkbox" name="genQuesOptView${totalGenQues}[]" value="${this.value}">
                            <label class="form-check-label" for="Option1">${this.value}</label>
                        </div>`;
                    }
                }
            })

            let quesionBlc = `<div class="singleGenQues singleGenQues_${totalGenQues}" key="${totalGenQues}">
                            <div class="form-check innerGenQues">
                               <label class="col-form-label question_name">${$("#genQuesNameEdit").val()}
                               <input type="hidden" name="genQuesNameView[]" value="${$("#genQuesNameEdit").val()}" />
                               <input type="hidden" name="genQuesTypeView${totalGenQues}[]" value="${quesType}" />
                               <input type="hidden" name="genQuesIdView${totalGenQues}[]" value="${genQuesIdJs}" />


                               </label><br/>
                                ${quesOptions }
                                <br/>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary delGenQues">Delete</button> &nbsp; <button type="button" class="btn btn-primary editGenQues">Edit</button>
                            </div>
                            <hr/></div>`;

            /*if($("#hiddenGenBlcNum").val() != undefined && $("#hiddenGenBlcNum").val() != "")
            {
                $("#editedGenQuesHidden").html(quesionBlc);
                if($(".singleGenQues_"+$("#hiddenGenBlcNum").val()).length > 0)
                {
                    //$(".singleGenQues_"+$("#hiddenGenBlcNum").val()).remove();
                    $(".singleGenQues_"+$("#hiddenGenBlcNum").val()).html($("#editedGenQuesHidden").find(".singleGenQues").html());
                }
            } else
            {
                $(".genQuesBlock").append(quesionBlc);
            }*/

            //$(".genQuesBlock").append(quesionBlc);

            $(".singleGenQues_"+quesionBlcNoJs).html(quesionBlc);

            $(".generalQue_errEdit").text("").removeClass("error");
            $("#generalQuesModalEdit").find('input[type="text"], textarea').val("");
            $("#hiddenGenBlcNumEdit").val("");
    $('#generalQuesModalEdit').modal('hide');


       }
})


    $(document).off("click", ".	").on("click", ".addLeadQuestion", function(){
        let clickedDependId = $("#clickedDependId").val();
        let quesOptions = "";
        $(".leadQuesOpt").each(function(){
            if(this.value != "")
            {
                quesOptions += `<div class="form-group">
                    <input class="form-check-input changeStatus" type="radio" value="${this.value}">
                    <input type="hidden" name="leadQuesOptView${clickedDependId}[]" value="${this.value}" >
                    <label class="form-check-label leadQuesLabls">${this.value}</label>
                </div>`;
            }
        })
        quesOptions += `<div class="clearfix"></div>`;

        $(".singleLeadQues_"+clickedDependId).find(".leaderOptions").html(quesOptions);
        $(".singleLeadQues_"+clickedDependId).find(".openLeadQuesModal").text("Edit");
        $("#leaderQuesModal").find('input, textarea').val("");
        $("#leaderQuesModal").modal("hide");

    })

    $(document).off("click", ".delGenQues").on("click", ".delGenQues", function(){
        $(this).closest(".singleGenQues").remove();
    })

    $(document).off("click", ".editGenQues").on("click", ".editGenQues", function(){

        let qname = $(this).closest(".singleGenQues").find(".question_name").text();//alert(qname);
        let genBlkNum = $(this).closest(".singleGenQues").attr("key");
        $('#generalQuesModalEdit').find("#genQuesNameEdit").val(qname);
        $('#generalQuesModalEdit').find("#hiddenGenBlcNumEdit").val(genBlkNum);

        var optCnt = 0;
        $(this).closest(".singleGenQues").find(".question_name_options").each(function(){
            optCnt++;
            $("#genQuesOptEdit"+optCnt).val($(this).text());
        })

        $('#generalQuesModalEdit').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    })

    $(document).off("click", ".changeAType").on("click", ".changeAType", function(){
        if($('input[name="atype"]:checked').val() == 1)
        {
            $(".areaTypeBlock").show();
            $(".muncipalBlock").hide();
        } else if($('input[name="atype"]:checked').val() == 2)
        {
            $(".muncipalBlock").show();
            $(".areaTypeBlock").hide();
        }

    })

    $(document).off("change", "#surveyState").on("change", "#surveyState", function(){
        if($(this).val() != '')
        {
            if($('input[name="atype"]:checked').val() == 1)
            {
                getParliamentAssemResults(2);
                $("#constituency").html("");
            } else if($('input[name="atype"]:checked').val() == 2)
            {
                getMuncipalityWardResults(1);
            }
        }
    })

    $(document).off("change", "#parliament").on("change", "#parliament", function(){
        if($(this).val() != '')
        {
            getParliamentAssemResults(2);
        }
    })

    $(document).off("change", "#municipality").on("change", "#municipality", function(){
        if($(this).val() != '')
        {
            getMuncipalityWardResults(2);
        }
    })

    $(document).off("click", ".btnSubmit").on("click", ".btnSubmit", function(){

        $(".required").each(function(){
            if($(this).val().trim() == "")
            {
                let txt = "Please enter "+$(this).attr("placeholder");
                $(this).closest('div').find(".validate_msg").text(txt).addClass("error");
            } else
            {
                $(this).closest('div').find(".validate_msg").text("").removeClass("error");
            }
        })

        if($("#tabl").find(".error").length == 0)
        {
            if($("#surveyState").val() == "")
            {
                $("#surveyState").closest('div').find(".validate_msg").text("Please select state").addClass("error");
            } else $("#surveyState").closest('div').find(".validate_msg").text("").removeClass("error");

            if($('input[name="atype"]:checked').val() == 1)
            {
                if($("#parliament").val() == "")
                {
                    $(".parliament_err").text("Select parliament").addClass("error");
                } else
                {
                    $(".parliament_err").text("").removeClass("error");
                }

                if($("#constituency").val() == "")
                {
                    $(".constituency_err").text("Select constituency").addClass("error");
                } else
                {
                    $(".constituency_err").text("").removeClass("error");
                }
            } else if($('input[name="atype"]:checked').val() == 2)
            {
                if($("#municipality").val() == "")
                {
                    $(".municipality_err").text("Select municipality").addClass("error");
                } else
                {
                    $(".municipality_err").text("").removeClass("error");
                }

                if($("#ward").val() == "")
                {
                    $(".ward_err").text("Select ward").addClass("error");
                } else
                {
                    $(".ward_err").text("").removeClass("error");
                }
            }

        }

        if($("#tab2").find(".error").length == 0)
        {
            if($(".genQuesBlock").find(".singleGenQues").length == 0)
            {
                $(".generalQue_err").text("Add general question").addClass("error");
                //$(".tab3").trigger("click");
            } else $(".generalQue_err").text("").removeClass("error");
        }

        if($("#tab3").find(".error").length == 0)
        {
            if($("#skipleadques").prop("checked") == false)
            {
                if($("#leadQuesName").val() == "")
                {
                    $(".leaderQues_err").text("Enter leader question").addClass("error");
                } else $(".leaderQues_err").text("").removeClass("error");
                //$(".tab4").trigger("click");
            } else $(".leaderQues_err").text("").removeClass("error");
        }

        if($("#tab4").find(".error").length == 0)
        {
            $(".required2").each(function(){
                if($(this).val() == "")
                {
                    let txt = "Please enter "+$(this).attr("placeholder");
                    $(this).closest('div').find(".validate_msg").text(txt).addClass("error");
                } else $(this).closest('div').find(".validate_msg").text("").removeClass("error");

                if($("#userList").val() == "")
                {
                    $(".userList_err").text("Plese select team leaders").addClass("error");
                } else $(".userList_err").text("").removeClass("error");
            })

        }

        if($("#tab1").find(".error").length > 0)
        {
            $(".tab1").trigger("click");
        } else if($("#tab2").find(".error").length > 0)
        {
            $(".tab2").trigger("click");
        } else if($("#tab3").find(".error").length > 0)
        {
            $(".tab3").trigger("click");
        } else if($("#tab4").find(".error").length > 0)
        {
            $(".tab4").trigger("click");
        } else if($("#tab5").find(".error").length > 0)
        {
            $(".tab5").trigger("click");
        }

        if($(".error").length == 0)
        {
            saveSurvey();
        }

    })

  })

  function getParliamentAssemResults(type)
  {
      $.ajax({
        type:"POST",
        url:$("#base_url").val()+"index.php/survey/getParliamentAssemResults",
        data: {"stateId":$("#surveyState").val(), "parliament":$("#parliament").val(), "type":type},
        success: function(data){
            let resp = JSON.parse(data);
            let opts = '';
            if(type == 1)
            {
                opts += '<option value="">Select</option>'
            }
             opts += resp.map((ele, ind) => {
                 return '<option key="atype_'+ele.id+'" value="'+ele.id+'">'+ele.name+'</option>'
             })
             if(type == 1)
                 $("#parliament").html(opts);
             else if(type == 2)
            {
                 $("#constituency").html(opts);
                $("#constituency").selectpicker('refresh');
            }

        }
    })
  }

  function getMuncipalityWardResults(type)
  {
      $.ajax({
        type:"POST",
        url:$("#base_url").val()+"index.php/survey/getMuncipalityWardResults",
        data: {"stateId":$("#surveyState").val(), "municipality":$("#municipality").val(), "type":type},
        success: function(data){
            let resp = JSON.parse(data);
            let opts = '';
            if(type == 1)
            {
                opts += '<option value="">Select</option>'
            }
             opts += resp.map((ele, ind) => {
                 return '<option key="atype_'+ele.id+'" value="'+ele.id+'">'+ele.name+'</option>'
             })
             if(type == 1)
                 $("#municipality").html(opts);
             else if(type == 2)
            {
                 $("#ward").html(opts);
                $("#ward").selectpicker('refresh');
            }
        }
    })
  }

  function saveSurvey()
  {

      $.ajax({
        type:"POST",
        url:$("#base_url").val()+"index.php/survey/saveSurvey",
        data: $("#add_survey_form").serialize(),
        success: function(data){
            resp = JSON.parse(data);
            if(resp.status == 200)
            {
                swal("Survey Successfully Created");
                setTimeout(function(){
                    window.location = $("#base_url").val()+"index.php/survey/surveyList";
                }, 1000);
            } else
            {
                swal("Error in Create Survey");
            }
        }
    })

  }
