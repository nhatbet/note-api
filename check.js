// linear search
function linearSearch(arr, n, x){
    for (i=0; i<n ; i++ ){
        if (arr[i] === x )
            return true;
    }
}

// binary search
function binarySearch(array, l, r, k) {
    let  mid = Math.floor((l + r) / 2);
    if (array[mid] == k) return true;
    else if (array[mid] > k) return binarySearch(array, l, mid - 1, k);
    else return binarySearch(array, mid + 1, r, k);
}
// main function to call the above function
// let arr = [2, 3, 4, 10, 40];
// let x = 10;
// if (binarySearch(arr, 0, arr.length-1, x)) console.log("Element is present");
// else console.log("Element is not present");

function ternarySearch(arr, k) {
    let size = arr.length;
    let l = 0;
    let r = size - 1;
    if (k < arr[0]) return false;
    if (k > arr[size-1]) return false;
    while (r >= l) {
        console.log(r, l)
        let partition = Math.floor((size-1)/3);
        let m1 = l + partition;
        let m2 = r - partition;
        if (arr[m1] == k) {
            return true;
        } else if (arr[m2] == k) {
            // console.log(arr[m2]);
            return arr[m2];
        } else if (k < arr[m1]) {
            r = m1 - 1;
        } else if (k > arr[m2]) {
            l = m2 + 1;
        } else {
            l = m1 + 1;
            r = m2 - 1;
        }
    }
}

// function quicksort
let sortArray = (arr)=>{
    let n = arr.length;
    for(var i=0;i<n;i++){
      var pivot = arr[n-1];
      var j = 0;
      for(var z = 0 ;z <= i;z++ )
      {
         if(arr[j] <= pivot)
         {
           j++;
         }
         var a = arr[j];
         arr[j] = arr[i];
         arr[i] = a;
      }
      arr[n-1] = arr[j];
      arr.splice(j+1, i-j);
      i = j;
   }
   return arr;
}

function jumpSearchInteractive(arr, k) {
    let size = arr.length;
    let m = Math.ceil(Math.sqrt(size));
    let tep = m;
    console.log('default tep', tep);

    while (arr[tep - 1] < k) {
        tep = tep + m;
        if (tep > size) {
            tep = size;
        }
    }

    console.log('tep', tep);

    for (let i = tep - m; i < tep; i++) {
        if (arr[i] == k) {
            console.log('i', i)
            console.log('val', arr[i])
        }
    }

}

jumpSearchInteractive([1,2,3,4,5,6,7,8,9, 10, 11, 12, 13, 14, 15], 8);



