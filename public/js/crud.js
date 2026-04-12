function store(url, data) {
    axios.post(url, data)
        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();
        })
        .catch(function (error) {
            if (error.response && error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else if (error.response) {
                showMessage(error.response.data);
            }
        });
}

function storepart(url, data) {
    axios.post(url, data)
        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();
        })
        .catch(function (error) {
            if (error.response && error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else if (error.response) {
                showMessage(error.response.data);
            }
        });
}

function storeRoute(url, data) {
    axios.post(url, data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function (response) {
        window.location = response.data.redirect;
    })
    .catch(function (error) {
        if (error.response && error.response.data.errors !== undefined) {
            showErrorMessages(error.response.data.errors);
        } else if (error.response) {
            showMessage(error.response.data);
        }
    });
}

function storeRedirect(url, data, redirectUrl) {
    axios.post(url, data)
        .then(function (response) {
            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
            if (error.response) showMessage(error.response.data);
        });
}

function update(url, data, redirectUrl) {
    axios.put(url, data)
        .then(function (response) {
            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
            if (error.response) showMessage(error.response.data);
        });
}

function updateRoute(url, data) {
    axios.put(url, data)
        .then(function (response) {
            window.location = response.data.redirect;
        })
        .catch(function (error) {
            console.log(error.response);
            if (error.response) showMessage(error.response.data);
        });
}

function updateReload(url, data, redirectUrl) {
    axios.put(url, data)
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error.response);
        });
}

function updatePage(url, data) {
    axios.post(url, data)
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
            console.log(error.response);
        });
}

function confirmDestroy(url, td) {
    Swal.fire({
        title: 'هل أنت متأكد من عملية الحذف ؟',
        text: "لا يمكن التراجع عن عملية الحذف",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td);
        }
    });
}

function destroy(url, td) {
    axios.delete(url)
        .then(function (response) {
            td.closest('tr').remove();
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تمت عملية الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500
            });
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'فشلت عملية الحذف',
                showConfirmButton: false,
                timer: 1500
            });
        });
}

function showErrorMessages(errors) {
    let errorAlert = document.getElementById('error_alert');
    if (errorAlert) {
        errorAlert.hidden = false;
        var errorMessagesUl = document.getElementById("error_messages_ul");
        errorMessagesUl.innerHTML = '';

        for (var key of Object.keys(errors)) {
            var newLI = document.createElement('li');
            // التأكد من جلب نص الخطأ الأول لكل حقل
            newLI.appendChild(document.createTextNode(errors[key][0]));
            errorMessagesUl.appendChild(newLI);
        }
    }
}

function clearAndHideErrors() {
    let errorAlert = document.getElementById('error_alert');
    if (errorAlert) {
        errorAlert.hidden = true;
        var errorMessagesUl = document.getElementById("error_messages_ul");
        errorMessagesUl.innerHTML = '';
    }
}

function clearForm() {
    // يحاول البحث عن الفورم سواء كان الـ ID بـ (_) أو (-)
    let form = document.getElementById("create_form") || document.getElementById("create-form");
    if (form) {
        form.reset();
    }
}

function showMessage(data) {
    Swal.fire({
        position: 'center',
        // إذا لم يرسل السيرفر أيقونة، نحددها بناءً على وجود رسالة نجاح أو خطأ
        icon: data.icon || (data.errors ? 'error' : 'success'),
        // إذا كان هناك title نعرضه، وإلا نعرض الـ message القادمة من السيرفر
        title: data.title || data.message || 'Error!',
        showConfirmButton: false,
        timer: 1500
    });
}
