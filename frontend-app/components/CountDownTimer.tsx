"use client";

import React from "react";

import useCountDownTime from "@/hooks/useCountDownTime";

const CountDownTimer = () => {
  const timeLeft = useCountDownTime();

  return (
    <div className="inline-flex rounded-lg bg-primary px-3 py-2 font-medium text-white">
      Ends in :{timeLeft.hours}:{timeLeft.minutes}:{timeLeft.seconds}
    </div>
  );
};

export default CountDownTimer;
