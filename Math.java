public class Math {
    //Divide method which returns a whole integer
    private int divide(int num1, int num2){
        if (num2 == 0){
            System.out.println("Divisor cannot be 0")
            return "null"; 
        }
        int result = num1 / num2; 
        return result; 
    }
}