//open and close hamburger menu
$(function () {
    var hamburger = $('#hamburger');
    var sidebar = $('.sidebar');

    hamburger.on('click', function () {
        if (sidebar.hasClass('sidebar-active')) { // if menu is opened
            //close menu by removing active class
            sidebar.removeClass('sidebar-active');
            //make hamburger shape change
            hamburger.removeClass('fa-times');
            hamburger.addClass('fa-bars');
            //hide text and arrow
            $(".sidebar-item").addClass("hidden");
            $(".sidebar-item").removeClass("inline");
            //hide/close all opened submenues
            $('.aside-item').hide();
            //change all arrows which are up to down
            $('.arrow').removeClass('fa-angle-up');
            $('.arrow').addClass('fa-angle-down');
        } else {
            //open menu
            sidebar.addClass('sidebar-active');
            //make hamburger shape change
            hamburger.addClass('fa-times');
            hamburger.removeClass('fa-bars');
            //show text and arrow
            $(".sidebar-item").removeClass("hidden");
            $(".sidebar-item").addClass("inline");
        }
    });
});

//open close submenu
$(function () {
    var asideArrow = $('.asideArrow');
    asideArrow.on('click', function () {
        //find on which arrow is clicked
        var num = this.id.match(/\d+/)[0];
        //toggle submenu on click
        $('#aside-item_' + num).slideToggle();
        //change arrow on up or down
        if ($('#arrow-collapse_' + num).hasClass('fa-angle-down')) {
            $('#arrow-collapse_' + num).addClass('fa-angle-up');
            $('#arrow-collapse_' + num).removeClass('fa-angle-down');
        } else {
            $('#arrow-collapse_' + num).addClass('fa-angle-down');
            $('#arrow-collapse_' + num).removeClass('fa-angle-up');
        }
    });
});


//when chekbox is cheked button is enabled, otherwise it is disabled
$(function () {
    $('.form-checkbox').click(function () {
        if ($('.form-checkbox:checked').length > 0) {
            $('.disabled-btn').removeAttr('disabled');
        } else {
            $('.disabled-btn').attr('disabled', 'disabled');
        }
    });
});

$(document).ready(function () {

    // $('#tabMenu a[href="#{{ old('tabMultimedia') }}"]').tab('show');

    $('#authorsFilterCancel').click(function (e) {
        e.preventDefault();
        $('.authorsFilterCancel').prop("checked", false);
    })

    $('#categoriesFilterCancel').click(function (e) {
        e.preventDefault();
        $('.categoriesFilterCancel').prop("checked", false);
    })

    $('#studentsFilterCancel').click(function (e) {
        e.preventDefault();
        $('.studentsFilterCancel').prop("checked", false);
    })

    $('#librariansFilterCancel').click(function (e) {
        e.preventDefault();
        $('.librariansFilterCancel').prop("checked", false);
    })

    $('#booksFilterCancel').click(function (e) {
        e.preventDefault();
        $('.booksFilterCancel').prop("checked", false);
    })

    $('#dateFilterCancel').click(function (e) {
        e.preventDefault();
        $('.dateFilterCancel').val("");
    })

    $('#returnedFilterCancel').click(function (e) {
        e.preventDefault();
        $('.returnedFilterCancel').val("");
    })

    //dashboardAktivnost filter za pretragu aktivnosti
    $('#studentsFilter, #dateFilter, #librariansFilter, #booksFilter').click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var students = [];
        var books = [];
        var librarians = [];
        students = $('input:checked[name="studentsFilter[]"]').map( function() {
            return $(this).val();
        }).get();

        books = $('input:checked[name="booksFilter[]"]').map( function() {
            return $(this).val();
        }).get();

        librarians = $('input:checked[name="librariansFilter[]"]').map( function() {
            return $(this).val();
        }).get();

        var dateFrom = $('#dateFromFilter').val();
        var dateTo = $('#dateToFilter').val();

        var subcat = '';

        $.ajax({
            type: "POST",
            data: {
                students: students,
                books: books,
                librarians: librarians,
                dateFrom: dateFrom,
                dateTo: dateTo,
            },
            url: "/filterActivities",
            dataType: 'json',
            success: function (response) {

                if (response.activities.length > 0) {
                  $('#activityCards3').hide();
                  $('#activityCards2').show();
                    $('#activityCards').hide();
                    var activities = response.activities;

                    activities.forEach(activity => {
                        subcat += '<div class="activity-card2 hidden flex-row mb-[30px]">';
                        subcat += '<div class="w-[60px] h-[60px]">';
                        subcat += '<img class="rounded-full" src="/storage/image/'+ activity.librarian.photo + '" alt="">';
                        subcat += '</div>';
                        subcat += '<div class="ml-[15px] mt-[5px] flex flex-col">';
                        subcat += '<div class="text-gray-500 mb-[5px]">';
                        subcat += '<p class="uppercase">';
                        subcat += 'Izdavanje knjige';
                        subcat += '<span class="inline lowercase">';
                        subcat += '</span>';
                        subcat += '</p>';
                        subcat += '</div>';
                        subcat += '<div class="">';
                        subcat += '<p>';
                        subcat += '<a href="/librarianProfile/' + activity.librarian.id + '" class="text-[#2196f3] hover:text-blue-600">';
                        subcat += activity.librarian.name;
                        subcat += '</a>';
                        subcat += ' rented a book ';
                        subcat += '<a href="/bookDetails/' + activity.book.id + '" class="font-medium">';
                        subcat += activity.book.title;
                        subcat += '</a>';
                        subcat += ' to ';
                        subcat += '<a href="/studentProfile/' + activity.student.id + '" class="text-[#2196f3] hover:text-blue-600">';
                        subcat += activity.student.name;
                        subcat += '</a>';
                        subcat += ' on ';
                        subcat += '<span class="font-medium">';
                        subcat += activity.rent_date+'.';
                        subcat += '</span>';
                        subcat += '<a href="/rentDetails/' + activity.book.id + '/' + activity.student.id+'" class="text-[#2196f3] hover:text-blue-600">';
                        subcat += ' more details >>';
                        subcat += '</a>';
                        subcat += '</p>';
                        subcat += '</div>';
                        subcat += '</div>';
                        subcat += '</div>';
                    });

                    if(activities.length>10) {
                        subcat += '<div class="inline-block w-full mt-4">'
                        subcat += '<button type="button"'
                        subcat += 'class="btn-animation w-full px-4 py-2 text-sm tracking-wider text-gray-600 transition duration-300 ease-in border-[1px] border-gray-400 rounded activity-showMore2 hover:bg-gray-200 focus:outline-none focus:ring-[1px] focus:ring-gray-300">'
                        subcat += 'Show more'
                        subcat += '</button>'
                        subcat += '</div>'
                    }

                    $('#activityCards2').html(subcat);
                    $('#activityCards2').show();
                    activityCard2();
                    studentsString = students.toString();
                    if(studentsString != "") {
                        $('#studentsAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#studentsAll').text("Učenici: "+studentsString);
                    } else {
                        $('#studentsAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#studentsAll').text("Učenici: Svi");
                    }

                    librariansString = librarians.toString();
                    if(librariansString != "") {
                        $('#librariansAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#librariansAll').text("Bibliotekari: "+librariansString);
                    } else {
                        $('#librariansAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#librariansAll').text("Bibliotekari: Svi");
                    }

                    booksString = books.toString();
                    if(booksString != "") {
                        $('#booksAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#booksAll').text("Knjige: "+booksString);
                    } else {
                        $('#booksAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#booksAll').text("Knjige: Sve");
                    }

                    if(dateFrom != "" && dateTo != "") {
                        $('#dateAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#dateAll').text("Datum: "+dateFrom+" - "+dateTo);
                    } else {
                        $('#dateAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#dateAll').text("Datum: Svi");
                    }


                } else {

                    studentsString = students.toString();
                    if(studentsString != "") {
                        $('#studentsAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#studentsAll').text("Učenici: "+studentsString);
                    } else {
                        $('#studentsAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#studentsAll').text("Učenici: Svi");
                    }

                    librariansString = librarians.toString();
                    if(librariansString != "") {
                        $('#librariansAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#librariansAll').text("Bibliotekari: "+librariansString);
                    } else {
                        $('#librariansAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#librariansAll').text("Bibliotekari: Svi");
                    }

                    booksString = books.toString();
                    if(booksString != "") {
                        $('#booksAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#booksAll').text("Knjige: "+booksString);
                    } else {
                        $('#booksAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#booksAll').text("Knjige: Sve");
                    }

                    if(dateFrom != "" && dateTo != "") {
                        $('#dateAll').addClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#dateAll').text("Datum: "+dateFrom+" - "+dateTo);
                    } else {
                        $('#dateAll').removeClass("bg-blue-200 text-blue-800 px-[5px]");
                        $('#dateAll').text("Datum: Svi");
                    }

                    $('#activityCards2').hide();
                    $('#activityCards').hide();

                    $('#activityCards3').show();
                }
            },
            error: function () {
                console.log("greska");
            }
        })
    })

    //this will execute on page load(to be more specific when document ready event occurs)
    activityCard();

    // Open Modal
    modal = $(".modal");
    $(".show-modal").on('click', function () {
        modal.removeClass('hidden');
        modal.addClass('flex');
    })
    // Close Modal
    $(".close-modal").on('click', function () {
        modal.addClass('hidden');
        modal.removeClass('flex');
    })
});

    // Modal za potvrdu brisanja
    $(".show-deleteModal").on('click', function (e) {
        e.preventDefault();
        var id=$(this).attr('id');
        var modal_id = "delete-modal_"+id;
        $("."+modal_id).removeClass('hidden');
        $("."+modal_id).addClass('flex');
    });
    // Close Modal
    $(".cancel").on('click', function () {
        var id=$(this).attr('id');
        var modal_id = "delete-modal_"+id;
        $("."+modal_id).addClass('hidden');
        $("."+modal_id).removeClass('flex');
    });

function AddReadMore() {
    //This limit you can set after how much characters you want to show Read More.
    var carLmt = 1000;
    // Text to show when text is collapsed
    var readMoreTxt = " ... Prikaži više &#8681;";
    // Text to show when text is expanded
    var readLessTxt = " Prikaži manje &#8657;";


    //Traverse all selectors with this class and manupulate HTML part to show Read More
    $(".addReadMore").each(function () {
        if ($(this).find(".firstSec").length)
            return;

        var allstr = $(this).text();
        if (allstr.length > carLmt) {
            var firstSet = allstr.substring(0, carLmt);
            var secdHalf = allstr.substring(carLmt, allstr.length);
            var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
            $(this).html(strtoadd);
        }

    });
    //Read More and Read Less Click Event binding
    $(document).on("click", ".readMore,.readLess", function () {
        $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
    });
}

$(function () {
    //Calling function after Page Load
    AddReadMore();
});

// File upload
function dataFileDnD() {
    return {
        files: [],
        fileDragging: null,
        fileDropping: null,
        humanFileSize(size) {
            const i = Math.floor(Math.log(size) / Math.log(1024));
            return (
                (size / Math.pow(1024, i)).toFixed(2) * 1 +
                " " + ["B", "kB", "MB", "GB", "TB"][i]
            );
        },
        remove(index) {
            let files = [...this.files];
            files.splice(index, 1);

            this.files = createFileList(files);
        },
        drop(e) {
            let removed, add;
            let files = [...this.files];

            removed = files.splice(this.fileDragging, 1);
            files.splice(this.fileDropping, 0, ...removed);

            this.files = createFileList(files);

            this.fileDropping = null;
            this.fileDragging = null;
        },
        dragenter(e) {
            let targetElem = e.target.closest("[draggable]");

            this.fileDropping = targetElem.getAttribute("data-index");
        },
        dragstart(e) {
            this.fileDragging = e.target
                .closest("[draggable]")
                .getAttribute("data-index");
            e.dataTransfer.effectAllowed = "move";
        },
        loadFile(file) {
            const preview = document.querySelectorAll(".preview");
            const blobUrl = URL.createObjectURL(file);

            preview.forEach(elem => {
                elem.onload = () => {
                    URL.revokeObjectURL(elem.src); // free memory
                };
            });

            return blobUrl;
        },
        addFiles(e) {
            const files = createFileList([...this.files], [...e.target.files]);
            this.files = files;
            // this.form.formData.files = [...files];
          }
    
    };
}

function addFiles() {
   
    var fd = new FormData();
    var ins = document.getElementById('imageUpload').files.length;
    for (var x = 0; x < ins; x++) {
        fd.append("movieImages[]", document.getElementById('imageUpload').files[x]);
    }
    const bookId= $("input[name=editBookId]").val();
    fd.append('bookId',bookId);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        data : fd,
        url: "/updateImage",
        success: function(response){
            $('#successBookEdit').append('<div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px] fadeIn"><i class="fa fa-check mr-[5px]" aria-hidden="true"></i>'+response.success+'</div>');
            setTimeout(function(){
                location.reload();
            }, 2000);
        },
        error: function(response){
            $('#movieImageError').empty();
            $('#movieImageError').append(response.responseJSON.errors.movieImages);
        }
    });
}
function removeImage(image) {
    var imageId = image.id;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        processData: false,
        contentType: false,
        data: imageId,
        url: "/deleteImage/"+imageId,
        success: function(response){
            $('#successBookEdit').append('<div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px] fadeIn"><i class="fa fa-check mr-[5px]" aria-hidden="true"></i>'+response.success+'</div>');
            setTimeout(function(){
                location.reload();
            }, 2000);
        },
        error: function(response){
            $('#movieImageError').empty();
        }
    });
}

// Student image upload
var loadFileStudent = function (event) {
    var imageStudent = document.getElementById('image-output-student');
    imageStudent.style.display = "block";
    imageStudent.src = URL.createObjectURL(event.target.files[0]);
};

// Librarian image upload
var loadFileLibrarian = function (event) {
    var imageStudent = document.getElementById('image-output-librarian');
    imageStudent.style.display = "block";
    imageStudent.src = URL.createObjectURL(event.target.files[0]);
};

// Category icon upload
$("#icon-upload").change(function () {
    $("#icon-output").text(this.files[0].name);
});

function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable");
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[1];
            y = rows[i + 1].getElementsByTagName("TD")[1];
            if (x.children.length == 2) {
                if (x.children[1].children.length == 1) {
                    let [firstName, secondName] = [x.children[1].children[0], y.children[1].children[0]]
                    //check if the two rows should switch place:
                    if (firstName.innerHTML.toLowerCase() > secondName.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    let [firstName1, secondName1] = [x.children[1], y.children[1]]
                    if (firstName1.innerHTML.toLowerCase() > secondName1.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            } else if (x.children.length == 1) {
                let [firstName2, secondName2] = [x.children[0], y.children[0]]
                if (firstName2.innerHTML.toLowerCase() > secondName2.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
//rezervacije promjena statusa
let reservations = $('.reservations');
reservations.on('click', (event) => {
    if (event.target.classList.contains('reservedStatus')) {
        event.target.closest('.changeStatus').classList.add('hidden');
        event.target.closest('.changeStatus').nextElementSibling.classList.remove('hidden');
        event.target.closest('.changeStatus').nextElementSibling.nextElementSibling.nextElementSibling.children[0].classList.remove('hidden');
        event.target.closest('.changeBg').classList.remove('bg-gray-200');
    }
    if (event.target.classList.contains('deniedStatus')) {
        event.target.closest('.changeStatus').classList.add('hidden');
        event.target.closest('.changeStatus').nextElementSibling.nextElementSibling.classList.remove('hidden');
        event.target.closest('.changeStatus').nextElementSibling.nextElementSibling.nextElementSibling.children[0].classList.remove('hidden');
        event.target.closest('.changeBg').classList.remove('bg-gray-200');
    }

})
//ucenikEvidencija, evidencijaIznajmljivanja - funkcija promjene statusa
$(".reservedBook").click(function () {
    var checkMark = $(this);
    var changeColorStatus = checkMark.closest("tr").find(".borderColor")
    var changeTextStatus = checkMark.closest("tr").find(".borderText")
    changeColorStatus.removeClass('border-yellow-500')
    changeColorStatus.removeClass('bg-transparent')
    changeColorStatus.addClass('bg-yellow-200')
    changeTextStatus.text('Potvrdjene rezervacije')
    changeTextStatus.removeClass('text-yellow-500')
    changeTextStatus.addClass('text-yellow-700')
    checkMark.parent().addClass('hidden')
    checkMark.parent().next().removeClass('hidden')
    var backgroundRowChange = checkMark.closest("tr")
    backgroundRowChange.removeClass('bg-gray-200')
})

$(".deniedBook").click(function () {
    var checkMark = $(this);
    var changeColorStatus = checkMark.closest("tr").find(".borderColor")
    var changeTextStatus = checkMark.closest("tr").find(".borderText")
    changeColorStatus.removeClass('border-yellow-500')
    changeColorStatus.removeClass('bg-transparent')
    changeColorStatus.addClass('bg-red-200')
    changeTextStatus.text('Odbijene rezervacije')
    changeTextStatus.removeClass('text-yellow-500')
    changeTextStatus.addClass('text-red-800')
    checkMark.parent().addClass('hidden')
    checkMark.parent().next().removeClass('hidden')
    var backgroundRowChange = checkMark.closest("tr")
    backgroundRowChange.removeClass('bg-gray-200')
})

function sortTableDate(row) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = $(".sortTableDate");
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table[0].rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[row];
            y = rows[i + 1].getElementsByTagName("TD")[row];
            let first = $(x).text().split('.')
            let [d1, m1, y1] = [parseInt(first[0]), parseInt(first[1]), parseInt(first[2])]
            let second = $(y).text().split('.')
            let [d2, m2, y2] = [parseInt(second[0]), parseInt(second[1]), parseInt(second[2])]
            //check if the two rows should switch place:
            if (y1 > y2) {
                //if so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            } else if ((y1 == y2) && (m1 > m2)) {
                shouldSwitch = true;
                break;
            } else if ((y1 == y2 && m1 == m2) && d1 > d2) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}


$('#authorsMenu').on('click', function () {
    $('.authorsMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var authorsMenu = $(".authorsMenu");
    if (!authorsMenu.is(e.target) &&
        authorsMenu.has(e.target).length === 0 &&
        !$(e.target).is('.authorsMenu')) {
        authorsMenu.slideUp();
    }
});

$('#categoriesMenu').on('click', function () {
    $('.categoriesMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var categoriesMenu = $(".categoriesMenu");
    if (!categoriesMenu.is(e.target) &&
        categoriesMenu.has(e.target).length === 0 &&
        !$(e.target).is('.categoriesMenu')) {
        categoriesMenu.slideUp();
    }
});


$('.studentsDrop-toggle').on('click', function () {
    $('.studentsMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var studentsMenu = $(".studentsMenu");
    if (!studentsMenu.is(e.target) &&
        studentsMenu.has(e.target).length === 0 &&
        !$(e.target).is('.studentsMenu')) {
        studentsMenu.slideUp();
    }
});

$('.librariansDrop-toggle').on('click', function () {
    $('.librariansMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var librariansMenu = $(".librariansMenu");
    if (!librariansMenu.is(e.target) &&
        librariansMenu.has(e.target).length === 0 &&
        !$(e.target).is('.librariansMenu')) {
        librariansMenu.slideUp();
    }
});

$('#booksMenu').on('click', function () {
    $('.booksMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var booksMenu = $(".booksMenu");
    if (!booksMenu.is(e.target) &&
        booksMenu.has(e.target).length === 0 &&
        !$(e.target).is('.booksMenu')) {
        booksMenu.slideUp();
    }
});

$('#transactionsMenu').on('click', function () {
    $('.transactionsMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var transactionsMenu = $(".transactionsMenu");
    if (!transactionsMenu.is(e.target) &&
        transactionsMenu.has(e.target).length === 0 &&
        !$(e.target).is('.transactionsMenu')) {
        transactionsMenu.slideUp();
    }
});

$('.dateDrop-toggle').on('click', function () {
    $('.dateMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var dateMenu = $(".dateMenu");
    if (!dateMenu.is(e.target) &&
        dateMenu.has(e.target).length === 0 &&
        !$(e.target).is('.dateMenu')) {
        dateMenu.slideUp();
    }
});

$('.delayDrop-toggle').on('click', function () {
    $('.delayMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var dateMenu = $(".delayMenu");
    if (!dateMenu.is(e.target) &&
        dateMenu.has(e.target).length === 0 &&
        !$(e.target).is('.delayMenu')) {
        dateMenu.slideUp();
    }
});

$('.returningDrop-toggle').on('click', function () {
    $('.returningMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var returningMenu = $(".returningMenu");
    if (!returningMenu.is(e.target) &&
        returningMenu.has(e.target).length === 0 &&
        !$(e.target).is('.returningMenu')) {
        returningMenu.slideUp();
    }
});

$('.statusDrop-toggle').on('click', function () {
    $('.statusMenu').toggle();
})

$(document).on('mouseup', function (e) {
    var statusMenu = $(".statusMenu");
    if (!statusMenu.is(e.target) &&
        statusMenu.has(e.target).length === 0 &&
        !$(e.target).is('.statusMenu')) {
        statusMenu.slideUp();
    }
});

function filterFunction(id, dropdown, item) {
    var input, filter, ul, li, a, i;

    input = document.getElementById(id);
    filter = input.value.toUpperCase();
    div = document.getElementById(dropdown);
    li = document.getElementsByClassName(item);
    text = div.getElementsByTagName("p");

    for (i = 0; i < text.length; i++) {
        txtValue = text[i].textContent || text[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

// Multiple select dropdown list - new book
function dropdown() {
    return {
        options: [],
        selected: [],
        show: false,
        open() {
            this.show = true
        },
        close() {
            this.show = false
        },
        isOpen() {
            return this.show === true
        },
        select(index, event) {

            if (!this.options[index].selected) {
                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);
            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false
            }
        },
        remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);
        },
        loadOptions() {
            const options = document.getElementById('category').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        loadOptionsEdit() {
            const options = document.getElementById('categoryEdit').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        loadOptionsGenres() {
            const options = document.getElementById('genre').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        loadOptionsGenresEdit() {
            const options = document.getElementById('genreEdit').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        loadOptionsAuthors() {
            const options = document.getElementById('authors').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        loadOptionsAuthorsEdit() {
            const options = document.getElementById('authorsEdit').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }
        },
        selectedValues() {
            return this.selected.map((option) => {
                return this.options[option].value;
            })
        },
        selectedValuesCategoryEdit() {
            const options = document.getElementById('categoryEdit').options;
            return options[1].value;
        },
        selectedValuesGenreEdit() {
            const options = document.getElementById('genreEdit').options;
            return options[2].value;
        },
        selectedValuesAuthorsEdit() {
            const options = document.getElementById('authorsEdit').options;
            return options[0].value;
        }
    }
}

function returnDateFunction(numberOfDaysToAdd) {

    var selectedDate = new Date($('#rentDate').val());
    selectedDate.setDate(selectedDate.getDate() + parseInt(numberOfDaysToAdd));
    document.getElementById('returnDate').valueAsDate = selectedDate;
}

//click on one and check all checkboxes (vratiKnjigu.php)
$('.select-all').click(function () {
    if ($(this).is(':checked')) {
        $('.form-checkbox').prop('checked', true);
        $('tr').addClass('bg-gray-200');
    } else {
        $('.form-checkbox').prop('checked', false);
        $('tr').removeClass('bg-gray-200');
    }
});

$('.form-checkbox').click(function () {
    if ($(this).is(':checked')) {
        $(this).closest('tr').addClass('bg-gray-200');
    } else {
        $(this).closest('tr').removeClass('bg-gray-200');
    }
})

// Header - dropdown for create button
$('#dropdownCreate').click(function () {
    $('.dropdown-create').toggle();
});

$(document).on('mouseup', function (e) {
    var dropdownCreate = $(".dropdown-create");
    if (!dropdownCreate.is(e.target) &&
        dropdownCreate.has(e.target).length === 0 &&
        !$(e.target).is('.dropdownCreate')) {
        dropdownCreate.slideUp();
    }
});

// Header - dropdown for profile button
$('#dropdownProfile').click(function () {
    $('.dropdown-profile').toggle();
});

$(document).on('mouseup', function (e) {
    var dropdownProfile = $(".dropdown-profile");
    if (!dropdownProfile.is(e.target) &&
        dropdownProfile.has(e.target).length === 0 &&
        !$(e.target).is('.dropdownProfile')) {
        dropdownProfile.slideUp();
    }
});

// Category - table - dropdown
$(".dotsCategory").click(function () {
    var dotsCategory = $(this);
    var dropdownCategory = dotsCategory.closest("td").find(".dropdown-category");
    dropdownCategory.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownCategory = $(".dropdown-category");
    if (!dropdownCategory.is(e.target) &&
        dropdownCategory.has(e.target).length === 0) {
        dropdownCategory.slideUp();
    }
});

// Genre - table - dropdown
$(".dotsGenre").click(function () {
    var dotsGenre = $(this);
    var dropdownGenre = dotsGenre.closest("td").find(".dropdown-genre");
    dropdownGenre.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownGenre = $(".dropdown-genre");
    if (!dropdownGenre.is(e.target) &&
        dropdownGenre.has(e.target).length === 0) {
        dropdownGenre.slideUp();
    }
});

// Publisher - table - dropdown
$(".dotsPublisher").click(function () {
    var dotsPublisher = $(this);
    var dropdownPublisher = dotsPublisher.closest("td").find(".dropdown-publisher");
    dropdownPublisher.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownPublisher = $(".dropdown-publisher");
    if (!dropdownPublisher.is(e.target) &&
        dropdownPublisher.has(e.target).length === 0) {
        dropdownPublisher.slideUp();
    }
});

// Book bind - table - dropdown
$(".dotsBookBind").click(function () {
    var dotsBookBind = $(this);
    var dropdownBookBind = dotsBookBind.closest("td").find(".dropdown-book-bind");
    dropdownBookBind.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownBookBind = $(".dropdown-book-bind");
    if (!dropdownBookBind.is(e.target) &&
        dropdownBookBind.has(e.target).length === 0) {
        dropdownBookBind.slideUp();
    }
});

// Format - table - dropdown
$(".dotsFormat").click(function () {
    var dotsFormat = $(this);
    var dropdownFormat = dotsFormat.closest("td").find(".dropdown-format");
    dropdownFormat.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownFormat = $(".dropdown-format");
    if (!dropdownFormat.is(e.target) &&
        dropdownFormat.has(e.target).length === 0) {
        dropdownFormat.slideUp();
    }
});

// Script - table - dropdown
$(".dotsScript").click(function () {
    var dotsScript = $(this);
    var dropdownScript = dotsScript.closest("td").find(".dropdown-script");
    dropdownScript.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownScript = $(".dropdown-script");
    if (!dropdownScript.is(e.target) &&
        dropdownScript.has(e.target).length === 0) {
        dropdownScript.slideUp();
    }
});

// Librarian - table - dropdown
$(".dotsLibrarian").click(function () {
    var dotsLibrarian = $(this);
    var dropdownLibrarian = dotsLibrarian.closest("td").find(".dropdown-librarian");
    dropdownLibrarian.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownLibrarian = $(".dropdown-librarian");
    if (!dropdownLibrarian.is(e.target) &&
        dropdownLibrarian.has(e.target).length === 0) {
        dropdownLibrarian.slideUp();
    }
});

// Student - table - dropdown
$(".dotsStudent").click(function () {
    var dotsStudent = $(this);
    var dropdownStudent = dotsStudent.closest("td").find(".dropdown-student");
    dropdownStudent.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudent = $(".dropdown-student");
    if (!dropdownStudent.is(e.target) &&
        dropdownStudent.has(e.target).length === 0) {
        dropdownStudent.slideUp();
    }
});

// Student - profile - dropdown
$(".dotsStudentProfile").click(function () {
    $(".dropdown-student-profile").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentProfile = $(".dropdown-student-profile");
    if (!dropdownStudentProfile.is(e.target) &&
        dropdownStudentProfile.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentProfile')) {
        dropdownStudentProfile.slideUp();
    }
});

// Student - profile - record - dropdown
$(".dotsStudentProfileRecords").click(function () {
    $(".dropdown-student-profile-records").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentProfileRecords = $(".dropdown-student-profile-records");
    if (!dropdownStudentProfileRecords.is(e.target) &&
        dropdownStudentProfileRecords.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentProfileRecords')) {
        dropdownStudentProfileRecords.slideUp();
    }
});

// Student - profile - vracene knjige - dropdown
$(".dotsStudentReturnedBooks").click(function () {
    $(".student-returned-books").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentReturnedBooks = $(".student-returned-books");
    if (!dropdownStudentReturnedBooks.is(e.target) &&
        dropdownStudentReturnedBooks.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentReturnedBooks')) {
        dropdownStudentReturnedBooks.slideUp();
    }
});

// Student - profile - knjige u prekoracenju - dropdown
$(".dotsStudentBooksOverdue").click(function () {
    $(".student-overdue-books").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentBooksOverdue = $(".student-overdue-books");
    if (!dropdownStudentBooksOverdue.is(e.target) &&
        dropdownStudentBooksOverdue.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentBooksOverdue')) {
        dropdownStudentBooksOverdue.slideUp();
    }
});

// Student - profile - aktivne knjige - dropdown
$(".dotsStudentBooksActive").click(function () {
    $(".student-active-books").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentBooksActive = $(".student-active-books");
    if (!dropdownStudentBooksActive.is(e.target) &&
        dropdownStudentBooksActive.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentBooksActive')) {
        dropdownStudentBooksActive.slideUp();
    }
});

// Student - profile - arhivirane knjige - dropdown
$(".dotsStudentBooksArchived").click(function () {
    $(".student-archived-books").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentBooksArchived = $(".student-archived-books");
    if (!dropdownStudentBooksArchived.is(e.target) &&
        dropdownStudentBooksArchived.has(e.target).length === 0 &&
        !$(e.target).is('.dotsStudentBooksArchived')) {
        dropdownStudentBooksArchived.slideUp();
    }
});

// Student - profile - book record - dropdown
$(".dotsStudentProfileBookRecord").click(function () {
    var dotsStudentProfileBookRecord = $(this);
    var dropdownStudentProfileBookRecords = dotsStudentProfileBookRecord.closest("td").find(".dropdown-student-profile-record-book");
    dropdownStudentProfileBookRecords.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentProfileBookRecords = $(".dropdown-student-profile-record-book");
    if (!dropdownStudentProfileBookRecords.is(e.target) &&
        dropdownStudentProfileBookRecords.has(e.target).length === 0) {
        dropdownStudentProfileBookRecords.slideUp();
    }
});

// Student - profile - vracene knjige tabela - dropdown
$(".dotsStudentReturnedBooksTable").click(function () {
    var dotsStudentReturnedBooksTable = $(this);
    var dropdownStudentReturnedBooksTable = dotsStudentReturnedBooksTable.closest("td").find(".student-returned-books-table");
    dropdownStudentReturnedBooksTable.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownStudentReturnedBooksTable = $(".student-returned-books-table");
    if (!dropdownStudentReturnedBooksTable.is(e.target) &&
        dropdownStudentReturnedBooksTable.has(e.target).length === 0) {
        dropdownStudentReturnedBooksTable.slideUp();
    }
});

// Student - profile - knjige u prekoracenju tabela - dropdown
$(".dotsStudentOverdueBooks").click(function () {
    var dotsStudentOverdueBooks = $(this);
    var dropdownOverdueBooks = dotsStudentOverdueBooks.closest("td").find(".student-overdue-books-table");
    dropdownOverdueBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownOverdueBooks = $(".student-overdue-books-table");
    if (!dropdownOverdueBooks.is(e.target) &&
        dropdownOverdueBooks.has(e.target).length === 0) {
        dropdownOverdueBooks.slideUp();
    }
});

// Student - profile - aktivne knjige tabela - dropdown
$(".dotsStudentActiveBooks").click(function () {
    var dotsStudentActiveBooks = $(this);
    var dropdownActiveBooks = dotsStudentActiveBooks.closest("td").find(".student-active-books-table");
    dropdownActiveBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownActiveBooks = $(".student-active-books-table");
    if (!dropdownActiveBooks.is(e.target) &&
        dropdownActiveBooks.has(e.target).length === 0) {
        dropdownActiveBooks.slideUp();
    }
});

// Student - profile - arhivirane knjige tabela - dropdown
$(".dotsStudentArchivedBooks").click(function () {
    var dotsStudentArchivedBooks = $(this);
    var dropdownArchivedBooks = dotsStudentArchivedBooks.closest("td").find(".student-archived-books-table");
    dropdownArchivedBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownArchivedBooks = $(".student-archived-books-table");
    if (!dropdownArchivedBooks.is(e.target) &&
        dropdownArchivedBooks.has(e.target).length === 0) {
        dropdownArchivedBooks.slideUp();
    }
});

// Librarian - profile - dropdown
$(".dotsLibrarianProfile").click(function () {
    $(".dropdown-librarian-profile").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownLibrarianProfile = $(".dropdown-librarian-profile");
    if (!dropdownLibrarianProfile.is(e.target) &&
        dropdownLibrarianProfile.has(e.target).length === 0 &&
        !$(e.target).is('.dotsLibrarianProfile')) {
        dropdownLibrarianProfile.slideUp();
    }
});

// Izdate knjige - dropdown
$(".dotsRentedBooks").click(function () {
    var dotsRentedBooks = $(this);
    var dropdownRentedBooks = dotsRentedBooks.closest("td").find(".rented-books");
    dropdownRentedBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentedBooks = $(".rented-books");
    if (!dropdownRentedBooks.is(e.target) &&
        dropdownRentedBooks.has(e.target).length === 0) {
        dropdownRentedBooks.slideUp();
    }
});

// Vracene knjige - dropdown
$(".dotsReturnedBooks").click(function () {
    var dotsReturnedBooks = $(this);
    var dropdownReturnedBooks = dotsReturnedBooks.closest("td").find(".returned-books");
    dropdownReturnedBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownReturnedBooks = $(".returned-books");
    if (!dropdownReturnedBooks.is(e.target) &&
        dropdownReturnedBooks.has(e.target).length === 0) {
        dropdownReturnedBooks.slideUp();
    }
});

// Knjige u prekoracenju - dropdown
$(".dotsOverdueBooks").click(function () {
    var dotsOverdueBooks = $(this);
    var dropdownOverdueBooks = dotsOverdueBooks.closest("td").find(".overdue-books");
    dropdownOverdueBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownOverdueBooks = $(".overdue-books");
    if (!dropdownOverdueBooks.is(e.target) &&
        dropdownOverdueBooks.has(e.target).length === 0) {
        dropdownOverdueBooks.slideUp();
    }
});

// Aktivne rezervacije - dropdown
$(".dotsActiveReservations").click(function () {
    var dotsActiveReservations = $(this);
    var dropdownActiveReservations = dotsActiveReservations.closest("td").find(".active-reservations");
    dropdownActiveReservations.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownActiveReservations = $(".active-reservations");
    if (!dropdownActiveReservations.is(e.target) &&
        dropdownActiveReservations.has(e.target).length === 0) {
        dropdownActiveReservations.slideUp();
    }
});

// Arhivirane rezervacije - dropdown
$(".dotsArchivedReservations").click(function () {
    var dotsArchivedReservations = $(this);
    var dropdownArchivedReservations = dotsArchivedReservations.closest("td").find(".archived-reservations");
    dropdownArchivedReservations.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownArchivedReservations = $(".archived-reservations");
    if (!dropdownArchivedReservations.is(e.target) &&
        dropdownArchivedReservations.has(e.target).length === 0) {
        dropdownArchivedReservations.slideUp();
    }
});

// Autori - dropdown
$(".dotsAuthors").click(function () {
    var dotsAuthors = $(this);
    var dropdownAuthors = dotsAuthors.closest("td").find(".dropdown-authors");
    dropdownAuthors.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownAuthors = $(".dropdown-authors");
    if (!dropdownAuthors.is(e.target) &&
        dropdownAuthors.has(e.target).length === 0) {
        dropdownAuthors.slideUp();
    }
});

// Autori - profile - dropdown
$(".dotsAuthor").click(function () {
    $(".dropdown-author").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownAutor = $(".dropdown-author");
    if (!dropdownAutor.is(e.target) &&
        dropdownAutor.has(e.target).length === 0 &&
        !$(e.target).is('.dotsAuthor')) {
        dropdownAutor.slideUp();
    }
});

// Knjige - dropdown
$(".dotsBooks").click(function () {
    var dotsBooks = $(this);
    var dropdownBooks = dotsBooks.closest("td").find(".dropdown-books");
    dropdownBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownBooks = $(".dropdown-books");
    if (!dropdownBooks.is(e.target) &&
        dropdownBooks.has(e.target).length === 0) {
        dropdownBooks.slideUp();
    }
});

// Knjiga - osnovni detalji - dropdown
$(".dotsBookDetails").click(function () {
    $(".dropdown-book-details").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownBookDetails = $(".dropdown-book-details");
    if (!dropdownBookDetails.is(e.target) &&
        dropdownBookDetails.has(e.target).length === 0 &&
        !$(e.target).is('.dotsBookDetails')) {
        dropdownBookDetails.slideUp();
    }
});

// Izdaj knjigu - dropdown
$(".dotsRentBook").click(function () {
    $(".dropdown-rent-book").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentBook = $(".dropdown-rent-book");
    if (!dropdownRentBook.is(e.target) &&
        dropdownRentBook.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentBook')) {
        dropdownRentBook.slideUp();
    }
});

// Izdaj knjigu error - dropdown
$(".dotsRentBookError").click(function () {
    $(".dropdown-rent-book-error").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentBookError = $(".dropdown-rent-book-error");
    if (!dropdownRentBookError.is(e.target) &&
        dropdownRentBookError.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentBookError')) {
        dropdownRentBookError.slideUp();
    }
});

// Vrati knjigu - dropdown
$(".dotsReturnBook").click(function () {
    $(".dropdown-return-book").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownReturnBook = $(".dropdown-return-book");
    if (!dropdownReturnBook.is(e.target) &&
        dropdownReturnBook.has(e.target).length === 0 &&
        !$(e.target).is('.dotsReturnBook')) {
        dropdownReturnBook.slideUp();
    }
});

// Rezervisi knjigu - dropdown
$(".dotsReserveBook").click(function () {
    $(".dropdown-reserve-book").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownReserveBook = $(".dropdown-reserve-book");
    if (!dropdownReserveBook.is(e.target) &&
        dropdownReserveBook.has(e.target).length === 0 &&
        !$(e.target).is('.dotsReserveBook')) {
        dropdownReserveBook.slideUp();
    }
});

// Otpisi knjigu - dropdown
$(".dotsWriteOffBook").click(function () {
    $(".dropdown-writeoff-book").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownWriteOffBook = $(".dropdown-writeoff-book");
    if (!dropdownWriteOffBook.is(e.target) &&
        dropdownWriteOffBook.has(e.target).length === 0 &&
        !$(e.target).is('.dotsWriteOffBook')) {
        dropdownWriteOffBook.slideUp();
    }
});

// Knjiga - specifikacija - dropdown
$(".dotsBookSpecification").click(function () {
    $(".dropdown-book-specification").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownBookSpecification = $(".dropdown-book-specification");
    if (!dropdownBookSpecification.is(e.target) &&
        dropdownBookSpecification.has(e.target).length === 0 &&
        !$(e.target).is('.dotsBookSpecification')) {
        dropdownBookSpecification.slideUp();
    }
});

// Knjiga - multimedija - dropdown
$(".dotsBookMultimedia").click(function () {
    $(".dropdown-book-multimedia").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownBookMultimedia = $(".dropdown-book-multimedia");
    if (!dropdownBookMultimedia.is(e.target) &&
        dropdownBookMultimedia.has(e.target).length === 0 &&
        !$(e.target).is('.dotsBookMultimedia')) {
        dropdownBookMultimedia.slideUp();
    }
});

// Iznajmljivanje - izdate - dropdown
$(".dotsRentingRented").click(function () {
    $(".dropdown-renting-rented").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingRented = $(".dropdown-renting-rented");
    if (!dropdownRentingRented.is(e.target) &&
        dropdownRentingRented.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentingRented')) {
        dropdownRentingRented.slideUp();
    }
});

// Iznajmljivanje - vracene - dropdown
$(".dotsRentingReturned").click(function () {
    $(".dropdown-renting-returned").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingReturned = $(".dropdown-renting-returned");
    if (!dropdownRentingReturned.is(e.target) &&
        dropdownRentingReturned.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentingReturned')) {
        dropdownRentingReturned.slideUp();
    }
});

// Iznajmljivanje - prekoracenje - dropdown
$(".dotsRentingOverdue").click(function () {
    $(".dropdown-renting-overdue").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingOverdue = $(".dropdown-renting-overdue");
    if (!dropdownRentingOverdue.is(e.target) &&
        dropdownRentingOverdue.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentingOverdue')) {
        dropdownRentingOverdue.slideUp();
    }
});

// Iznajmljivanje - aktivne rezervacije - dropdown
$(".dotsRentingActiveReservations").click(function () {
    $(".dropdown-renting-active-reservations").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingActiveReservations = $(".dropdown-renting-active-reservations");
    if (!dropdownRentingActiveReservations.is(e.target) &&
        dropdownRentingActiveReservations.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentingActiveReservations')) {
        dropdownRentingActiveReservations.slideUp();
    }
});

// Iznajmljivanje - arhivirane rezervacije - dropdown
$(".dotsRentingArchivedReservations").click(function () {
    $(".dropdown-renting-archived-reservations").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingArchivedReservations = $(".dropdown-renting-archived-reservations");
    if (!dropdownRentingArchivedReservations.is(e.target) &&
        dropdownRentingArchivedReservations.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentingArchivedReservations')) {
        dropdownRentingArchivedReservations.slideUp();
    }
});

// Izdavanje - detalji - dropdown
$(".dotsRentDetails").click(function () {
    $(".dropdown-rent-details").toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentDetails = $(".dropdown-rent-details");
    if (!dropdownRentDetails.is(e.target) &&
        dropdownRentDetails.has(e.target).length === 0 &&
        !$(e.target).is('.dotsRentDetails')) {
        dropdownRentDetails.slideUp();
    }
});

// Iznajmljivanje - izdate knjige - tabela - dropdown
$(".dotsRentingRentedBooks").click(function () {
    var dotsRentingRentedBooks = $(this);
    var dropdownRentingRentedBooks = dotsRentingRentedBooks.closest("td").find(".renting-rented-books");
    dropdownRentingRentedBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingRentedBooks = $(".renting-rented-books");
    if (!dropdownRentingRentedBooks.is(e.target) &&
        dropdownRentingRentedBooks.has(e.target).length === 0) {
        dropdownRentingRentedBooks.slideUp();
    }
});

// Iznajmljivanje - vracene knjige - tabela - dropdown
$(".dotsRentingReturnedBooks").click(function () {
    var dotsRentingReturnedBooks = $(this);
    var dropdownRentingReturnedBooks = dotsRentingReturnedBooks.closest("td").find(".renting-returned-books");
    dropdownRentingReturnedBooks.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingReturnedBooks = $(".renting-returned-books");
    if (!dropdownRentingReturnedBooks.is(e.target) &&
        dropdownRentingReturnedBooks.has(e.target).length === 0) {
        dropdownRentingReturnedBooks.slideUp();
    }
});

// Iznajmljivanje - knjige u prekoracenju - tabela - dropdown
$(".dotsRentingBooksOverdue").click(function () {
    var dotsRentingBooksOverdue = $(this);
    var dropdownRentingBooksOverdue = dotsRentingBooksOverdue.closest("td").find(".renting-books-overdue");
    dropdownRentingBooksOverdue.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingBooksOverdue = $(".renting-books-overdue");
    if (!dropdownRentingBooksOverdue.is(e.target) &&
        dropdownRentingBooksOverdue.has(e.target).length === 0) {
        dropdownRentingBooksOverdue.slideUp();
    }
});

// Iznajmljivanje - aktivne rezervacije - tabela - dropdown
$(".dotsRentingActiveReservationsTable").click(function () {
    var dotsRentingActiveReservationsTable = $(this);
    var dropdownRentingActiveReservationsTable = dotsRentingActiveReservationsTable.closest("td").find(".renting-active-reservations");
    dropdownRentingActiveReservationsTable.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingActiveReservationsTable = $(".renting-active-reservations");
    if (!dropdownRentingActiveReservationsTable.is(e.target) &&
        dropdownRentingActiveReservationsTable.has(e.target).length === 0) {
        dropdownRentingActiveReservationsTable.slideUp();
    }
});

// Iznajmljivanje - aktivne rezervacije - tabela - dropdown
$(".dotsRentingArchivedReservationsTable").click(function () {
    var dotsRentingArchivedReservationsTable = $(this);
    var dropdownRentingArchivedReservationsTable = dotsRentingArchivedReservationsTable.closest("td").find(".renting-archived-reservations");
    dropdownRentingArchivedReservationsTable.toggle();
})

$(document).on('mouseup', function (e) {
    var dropdownRentingArchivedReservationsTable = $(".renting-archived-reservations");
    if (!dropdownRentingArchivedReservationsTable.is(e.target) &&
        dropdownRentingArchivedReservationsTable.has(e.target).length === 0) {
        dropdownRentingArchivedReservationsTable.slideUp();
    }
});

//click on one and check all checkboxes(evidencijaKnjiga.php)
$('.checkAll').click(function () {
    if ($(this).is(':checked')) {
        $('.form-checkbox').prop('checked', true);
        $('tr').addClass('bg-gray-200');
        $('tr').children().eq(1).html('<a class="text-blue-800 border-l-2 border-gray-200" href="otpisiKnjigu.php"><i class="fa fa-trash ml-4"></i>  Izbriši knjigu</a>')
        $('tr').children().eq(2).html('')
        $('tr').children().eq(3).html('')
        $('tr').children().eq(4).html('')
        $('tr').children().eq(5).html('')
        $('tr').children().eq(6).html('')
        $('tr').children().eq(7).html('')
        $('tr').children().eq(8).html('')
    } else {
        $('.form-checkbox').prop('checked', false);
        $('tr').removeClass('bg-gray-200');
        $('tr').children().eq(1).html('Naziv knjige<a href="#"><i class="ml-2 fa-lg fas fa-long-arrow-alt-down" onclick="sortTable()"></i></a>')
        $('tr').children().eq(2).html('Autor<i class="ml-2 fas fa-filter"></i><div id="authorsDropdown" class="authorsMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300"><ul class="border-b-2 border-gray-300 list-reset"><li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300"><input class="w-full h-10 px-2 border-2 rounded focus:outline-none" placeholder="Search" onkeyup="filterFunction(" searchAuthors ", "authorsDropdown ")" id="searchAuthors"><br> <button class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900"><i class="fas fa-search"></i></button></li><div class="h-[200px] scroll font-normal"> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Autor Autorovic </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 2 </p>  </li>  <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg>  </div> </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 3  </p> </li>  <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Autor Autorovic 4  </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /></svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 5 </p> </li><li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"><input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 6 </p> </li> </div></ul><div class="flex pt-[10px] text-white "> <a href="#" class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">  Sacuvaj <i class="fas fa-check ml-[4px]"></i> </a> <a href="#"  class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]"> Ponisti <i class="fas fa-times ml-[4px]"></i> </a> </div></div>')
        $('tr').children().eq(3).html('Kategorija<i class="ml-2 fas fa-filter"></i><div id="kategorijeDropdown" class="kategorijeMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300"><ul class="border-b-2 border-gray-300 list-reset">  <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300"> <input class="w-full h-10 px-2 border-2 rounded focus:outline-none" placeholder="Search"  onkeyup="filterFunction("searchKategorije", "kategorijeDropdown")"  id="searchKategorije"><br><button class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">  <i class="fas fa-search"></i> </button> </li><div class="h-[200px] scroll font-normal"> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />   </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Romani </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Udzbenici </p></li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div   class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Drame </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg>  </div> </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Naucna fantastika </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Romedije  </p>  </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start"> <div   class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"   viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Trileri </p> </li> </div> </ul> <div class="flex pt-[10px] text-white "> <a href="#" class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]"> Sacuvaj <i class="fas fa-check ml-[4px]"></i> </a>  <a href="#" class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">  Ponisti <i class="fas fa-times ml-[4px]"></i> </a></div></div>')
        $('tr').children().eq(4).html('Na raspolaganju')
        $('tr').children().eq(5).html('Rezervisano')
        $('tr').children().eq(6).html('Izdato')
        $('tr').children().eq(7).html('U prekoračenju')
        $('tr').children().eq(8).html('Ukupna količina')
    }
});
$('.checkOthers').change(function () {
    var checked = $('#myTable').find(':checked').length;
    if (checked == 1) {
        $(this).addClass('bg-gray-200');
        $('tr').children().eq(1).html('<a class="text-blue-800" href="knjigaOsnovniDetalji.php"><i class="far fa-copy"></i>  Pogledaj detalje</a>')
        $('tr').children().eq(2).html('<a class="text-blue-800" href="editKnjiga.php.php"><i class="far fa-copy"></i>  Izmijeni knjigu</a>')
        $('tr').children().eq(3).html('<a class="text-blue-800 border-l-2 border-gray-200" href="otpisiKnjigu.php"><i class="fas fa-level-up-alt ml-4"></i>  Otpiši knjigu</a>')
        $('tr').children().eq(4).html('<a class="text-blue-800" href="izdajKnjigu.php"><i class="far fa-hand-scissors"></i>  Izdaj knjigu</a>')
        $('tr').children().eq(5).html('<a class="text-blue-800" href="vratiKnjigu.php"><i class="fas fa-redo-alt"></i>  Vrati knjigu</a>')
        $('tr').children().eq(6).html('<a class="text-blue-800" href="otpisiKnjigu.php"><i class="far fa-calendar-check"></i>  Rezerviši knjigu</a>')
        $('tr').children().eq(7).html('<a class="text-blue-800 border-l-2 border-gray-200" href="otpisiKnjigu.php"><i class="fa fa-trash ml-4"></i>  Izbriši knjigu</a>')
        $('tr').children().eq(8).html('')
    } else if (checked >= 2) {
        $(this).addClass('bg-gray-200');
        $('tr').children().eq(1).html('<a class="text-blue-800 border-l-2 border-gray-200" href="otpisiKnjigu.php"><i class="fa fa-trash ml-4"></i>  Izbriši knjigu</a>')
        $('tr').children().eq(2).html('')
        $('tr').children().eq(3).html('')
        $('tr').children().eq(4).html('')
        $('tr').children().eq(5).html('')
        $('tr').children().eq(6).html('')
        $('tr').children().eq(7).html('')
        $('tr').children().eq(8).html('')
    } else {
        $('.form-checkbox').prop('checked', false);
        $('tr').removeClass('bg-gray-200');
        $('tr').children().eq(1).html('Naziv knjige<a href="#"><i class="ml-2 fa-lg fas fa-long-arrow-alt-down" onclick="sortTable()"></i></a>')
        $('tr').children().eq(2).html('Autor<i class="ml-2 fas fa-filter"></i><div id="autoriDropdown" class="autoriMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300"><ul class="border-b-2 border-gray-300 list-reset"><li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300"><input class="w-full h-10 px-2 border-2 rounded focus:outline-none" placeholder="Search" onkeyup="filterFunction(" searchAutori ", "autoriDropdown ")" id="searchAutori"><br> <button class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900"><i class="fas fa-search"></i></button></li><div class="h-[200px] scroll font-normal"> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Autor Autorovic </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 2 </p>  </li>  <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg>  </div> </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 3  </p> </li>  <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Autor Autorovic 4  </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /></svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 5 </p> </li><li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"><input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg> </div> </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Autor Autorovic 6 </p> </li> </div></ul><div class="flex pt-[10px] text-white "> <a href="#" class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">  Sacuvaj <i class="fas fa-check ml-[4px]"></i> </a> <a href="#"  class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]"> Ponisti <i class="fas fa-times ml-[4px]"></i> </a> </div></div>')
        $('tr').children().eq(3).html('Kategorija<i class="ml-2 fas fa-filter"></i><div id="kategorijeDropdown" class="kategorijeMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300"><ul class="border-b-2 border-gray-300 list-reset">  <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300"> <input class="w-full h-10 px-2 border-2 rounded focus:outline-none" placeholder="Search"  onkeyup="filterFunction("searchKategorije", "kategorijeDropdown")"  id="searchKategorije"><br><button class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">  <i class="fas fa-search"></i> </button> </li><div class="h-[200px] scroll font-normal"> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />   </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Romani </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div  class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current" viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Udzbenici </p></li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start"> <div   class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0"> <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label>  <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Drame </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200"> <label class="flex items-center justify-start">  <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />  </svg>  </div> </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600"> Naucna fantastika </p> </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start"> <div class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500"> <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"  viewBox="0 0 20 20">  <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div> </label> <p class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Romedije  </p>  </li> <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200">  <label class="flex items-center justify-start"> <div   class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">  <input type="checkbox" class="absolute opacity-0">  <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"   viewBox="0 0 20 20"> <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /> </svg> </div>  </label> <p  class="block p-2 text-black cursor-pointer group-hover:text-blue-600">  Trileri </p> </li> </div> </ul> <div class="flex pt-[10px] text-white "> <a href="#" class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]"> Sacuvaj <i class="fas fa-check ml-[4px]"></i> </a>  <a href="#" class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">  Ponisti <i class="fas fa-times ml-[4px]"></i> </a></div></div>')
        $('tr').children().eq(4).html('Na raspolaganju')
        $('tr').children().eq(5).html('Rezervisano')
        $('tr').children().eq(6).html('Izdato')
        $('tr').children().eq(7).html('U prekoračenju')
        $('tr').children().eq(8).html('Ukupna količina')
    }
});

//open tabs for new book
function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace("active-book-nav", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    var nameTab = document.getElementById(tabName);
    // nameTab.style.display = "flex";

    nameTab.style.display = "block";

    evt.currentTarget.className += " active-book-nav";
}

//filter aktivnosti
// example of url -> url:"{{ route('updateArticle') }}" + '/' + id,

function activityCard() {
    size = $('.activity-card').length;
    x = 10;
    $('.activity-card:lt(' + x + ')').removeClass('hidden');
    $('.activity-card:lt(' + x + ')').addClass('flex');
    $('.activity-showMore').show();


    $('.activity-showMore').on('click', function () {
        x = (x + 10 < size) ? x + 10 : size;
        $('.activity-card:lt(' + x + ')').removeClass('hidden');
        $('.activity-card:lt(' + x + ')').addClass('flex');
        if (x == size) {
            $('.activity-showMore').hide();
        }
    });
}

function activityCard2() {
    size = $('.activity-card2').length;
    x = 10;
    $('.activity-card2:lt(' + x + ')').removeClass('hidden');
    $('.activity-card2:lt(' + x + ')').addClass('flex');
    $('.activity-showMore2').show();


    $('.activity-showMore2').on('click', function () {
        x = (x + 10 < size) ? x + 10 : size;
        $('.activity-card2:lt(' + x + ')').removeClass('hidden');
        $('.activity-card2:lt(' + x + ')').addClass('flex');
        if (x == size) {
            $('.activity-showMore2').hide();
        }
    });
}

//side menu active state
$(function(){
    // this will get the full URL at the address bar
    var url = window.location.href; 

    // passes on every "a" tag 
    $("#sidebar a").each(function() {
            // checks if its the same on the address bar
        if(url == (this.href)) { 
            $(this).closest("li").addClass("active-sideMenu");
        }
    });
});