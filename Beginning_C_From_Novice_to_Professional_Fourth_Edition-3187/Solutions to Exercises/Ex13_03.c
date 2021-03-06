/* Exercise 13.3 A macro to ouput the value of an expression */
#include <stdio.h>
/*
 The macro always produces a floating-point result of evaluating the expression.
 If you were to define the macro to produce an integer result, then it would only
 work with expressions involing integers.
*/
#define print_value(expr) printf("\n" #expr " = %f", ((double)(expr)))


int main(void)
{
  int x = 4;
  double y = 3.5;
  print_value(x);
  print_value(y);
  print_value(x*x*x - 5);
  print_value(x*y+10);
  print_value(x*x + x*y + y*y);
  return 0;
}


