import numpy as np
def show_dimensions(array: np.array) -> None:
    print(f"Array dimensions: {array.ndim}")
def filter_by_mod(array: np.array) -> np.array:
    filtered_array = []
    for i in range(len(array)):
        if array[i] % 2 == 0:
            filtered_array.append(True)
            continue
        filtered_array.append(False)
    return filtered_array
# Array of cero dimensions
numpy_array = np.array(0)
print(numpy_array)
show_dimensions(numpy_array)
# Array of one dimension
numpy_array = np.array([1,2,3])
print(numpy_array)
show_dimensions(numpy_array)
# Array of two dimensions
numpy_array = np.array([[1,2,3],[4,5,6]])
print(numpy_array)
show_dimensions(numpy_array)
# Array of three dimensions
numpy_array = np.array([[[1,2,3],[4,5,6]],[[7,8,9],[10,11,12]]])
print(numpy_array)
show_dimensions(numpy_array)
# Accessing indexes
print(numpy_array[0,1,-1]) # in this case is the number 6
# Slicing an array
print(f"It is a sliced array:{numpy_array[ : 1, 1: , 1: ]}") # in this case are the 5 and 6
# copies and views
copy = numpy_array.copy()
view = numpy_array.view()
copy[0,0,0] = 100
print(f"Copy: {copy}")
print(f"Original: {numpy_array}")
view[0,0,0] = 200
print(f"View: {view}")
print(f"original: {numpy_array}")
# copies and views
#filtering
new_array = np.array([1,2,3,4,5, 32, 46, 45, 23, 12])
filter = [True, False, True, False, True, False, True, False, True, False]
print(new_array[filter])
print(f"This are the even numbers: {np.sort(new_array[filter_by_mod(new_array)])}")
#para limpiar dimensiones se usa squeeze