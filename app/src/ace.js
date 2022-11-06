const handleSubmit = async () => {
    isFetching(true)
    const payload = {
      jobId,
      ext,
      code,
      input,
    };
    try {
      SetStatus("");
      setOutput("");
      const { data } = await axios.post(
        `/api/run`,
        payload
      );
      if (data.job) setOutput(data.jobOutput);

      let intervalId;

      intervalId = setInterval(async () => {
        const { data: dataRes } = await axios.get(
          `/api/status`,
          { params: { id: data.jobid } }
        );

        const { success, job, error } = dataRes;
        // console.log(dataRes);
        if (success) {
          const { status: jobStatus, output: jobOutput } = job;
          SetStatus(jobStatus);
          if (jobStatus === "running") return;
          setOutput(jobOutput);
          isFetching(false);
          clearInterval();
          clearInterval(intervalId);
        } else {
          // console.error(error);
          setOutput(error);
        }
      }, 1000);
    } catch ({ response }) {
      if (response) {
        console.log(response);
        const errMsg = response.data.err.stderr;
        setOutput(errMsg);
      } else {
        window.alert("Error Connection To server");
      }
    }
  };

  const onChange = (newValue) => {
    // console.log("change", newValue);
    setCode(newValue);
  };

  const setThemeHandler = (e) => {
    console.log(e.target.value);
  };


  const setmode = (ext) => {
    if (ext === "py") {
      setMode("python");
    }
    if (ext === "cpp") {
      setMode("c_cpp");
    }
    if (ext === "java"){
      setMode("java")
    }
  };

